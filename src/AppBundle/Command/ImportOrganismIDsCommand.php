<?php

namespace AppBundle\Command;


use AppBundle\Entity\Db;
use AppBundle\Entity\FennecDbxref;
use AppBundle\Entity\Organism;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

class ImportOrganismIDsCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $connectionName;

    private $mapping;

    private $skippedNoHit = 0;

    private $skippedMultiHits = 0;

    private $insertedEntries = 0;

    private $file;

    private $batchSize;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:import-organism-ids')

        // the short description shown while running "php bin/console list"
        ->setDescription('Importer for organism ids.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command allows you to import ids for existing organisms...\n".
            "The tsv file has to have the following columns:\n".
            "fennec_id\tdb_id\n\n".
            "instead of fennec_id the first column can be something that is mappable to fennec_id via --mapping\n\n"
        )
        ->addArgument('file', InputArgument::REQUIRED, 'The path to the input csv file')
        ->addOption('connection', 'c', InputOption::VALUE_REQUIRED, 'The database version')
        ->addOption('provider', 'p', InputOption::VALUE_REQUIRED, 'The name of the database provider (e.g. NCBI Taxonomy)', null)
        ->addOption('mapping', "m", InputOption::VALUE_REQUIRED, 'Method of mapping for id column. If not set fennec_ids are assumed and no mapping is performed', null)
        ->addOption('description', 'd', InputOption::VALUE_REQUIRED, 'Description of the database provider', null)
        ->addOption('skip-unmapped', 's', InputOption::VALUE_NONE, 'do not exit if a line can not be mapped (uniquely) to a fennec_id instead skip this entry', null)
        ->addOption('batch-size', 'b', InputOption::VALUE_REQUIRED, 'Process large files in batches of this number of lines. Avoid out of memory errors', 1000)
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Organism ID Importer',
            '====================',
            '',
        ]);
        if(!$this->checkOptions($input, $output)){
            return;
        }
        $this->initConnection($input);
        $lines = intval(exec('wc -l '.escapeshellarg($input->getArgument('file')).' 2>/dev/null'));
        $this->batchSize = $input->getOption('batch-size');
        $progress = new ProgressBar($output, $lines);
        $progress->start();
        $this->em->getConnection()->beginTransaction();
        try{
            $needs_mapping = $input->getOption('mapping') !== null;
            $this->file = fopen($input->getArgument('file'), 'r');
            $provider = $this->getOrInsertProvider($input->getOption('provider'), $input->getOption('description'));
            while(count($lines = $this->getNextBatchOfLines()) > 0){
                if($needs_mapping) {
                    $this->mapping = $this->getMapping($lines, $input->getOption('mapping'));
                    if (!$input->getOption('skip-unmapped')) {
                        foreach ($this->mapping as $id => $value) {
                            if ($value === null) {
                                throw new \Exception('Error no mapping to fennec id found for: ' . $id);
                            } elseif (is_array($value)) {
                                throw new \Exception('Error multiple mappings to fennec ids found for: ' . $id . ' (' . implode(',',
                                        $value) . ')');
                            }
                        }
                    }
                }
                foreach ($lines as $line) {
                    $fennec_id = $line[0];
                    if($needs_mapping){
                        $fennec_id = $this->mapping[$fennec_id];
                        if($fennec_id === null){
                            ++$this->skippedNoHit;
                            $progress->advance();
                            continue;
                        } elseif (is_array($fennec_id)){
                            ++$this->skippedMultiHits;
                            $progress->advance();
                            continue;
                        }
                    }
                    $dbid = $line[1];
                    if($dbid == "" or $fennec_id == ""){
                        throw new \Exception('Illegal line: '.join(" ",$line));
                    }
                    $this->insertDbxref($fennec_id, $dbid, $provider);
                    ++$this->insertedEntries;
                    $progress->advance();
                }
                $this->em->flush();
            }
            $this->em->getConnection()->commit();
        } catch (\Exception $e){
            $this->em->getConnection()->rollBack();
            $output->writeln('<error>'.$e->getMessage().'</error>');
            return;
        }
        fclose($this->file);
        $progress->finish();

        $output->writeln('');
        $table = new Table($output);
        $table->addRow(array('Imported IDs', $this->insertedEntries));
        $table->addRow(array('Skipped (no hit)', $this->skippedNoHit));
        $table->addRow(array('Skipped (multiple hits)', $this->skippedMultiHits));
        $table->render();
    }

    private function getNextBatchOfLines(){
        $lines = array();
        $i = 0;
        while ($i<$this->batchSize && ($line = fgetcsv($this->file, 0, "\t")) != false) {
            $lines[] = $line;
            $i++;
        }
        return $lines;
    }

    /**
     * @param $name
     * @param $description
     * @return Db
     */
    protected function getOrInsertProvider($name, $description)
    {
        $provider = $this->em->getRepository('AppBundle:Db')->findOneBy(array(
            'name' => $name
        ));
        if($provider === null){
            $provider = new Db();
            $provider->setName($name);
            $provider->setDate(new \DateTime());
            $provider->setDescription($description);
            $this->em->persist($provider);
            $this->em->flush();
        }
        return $provider;
    }

    /**
     * @param $sciname
     * @return int
     */
    protected function insertOrganism($sciname){
        $organism = new Organism();
        $organism->setScientificName($sciname);
        $this->em->persist($organism);
        $this->em->flush();
        return $organism->getFennecId();
    }

    /**
     * @param $fennec_id
     * @param $dbid
     * @param $provider
     * @return FennecDbxref
     */
    protected function insertDbxref($fennec_id, $dbid, $provider){
        $dbxref = new FennecDbxref();
        $dbxref->setDb($provider);
        $dbxref->setFennec($this->em->getRepository('AppBundle:Organism')->find($fennec_id));
        $dbxref->setIdentifier($dbid);
        $this->em->persist($dbxref);
        return $dbxref;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return boolean
     */
    protected function checkOptions(InputInterface $input, OutputInterface $output)
    {
        if($input->getOption('provider') === null){
            $output->writeln('<error>Provider (--provider) is required, none given.</error>');
            return false;
        }
        if(!file_exists($input->getArgument('file'))){
            $output->writeln('<error>File does not exist: '.$input->getArgument('file').'</error>');
            return false;
        }
        return true;
    }

    /**
     * @param InputInterface $input
     */
    protected function initConnection(InputInterface $input)
    {
        $this->connectionName = $input->getOption('connection');
        if ($this->connectionName === null) {
            $this->connectionName = $this->getContainer()->get('doctrine')->getDefaultConnectionName();
        }
        $orm = $this->getContainer()->get('app.orm');
        $this->em = $orm->getManagerForVersion($this->connectionName);
    }

    private function getMapping($lines, $method){
        $func = function($value) { return $value[0]; };
        $ids = array_map($func, $lines);
        if($method === 'scientific_name'){
            $mapper = $this->getContainer()->get('app.api.webservice')->factory('mapping', 'byOrganismName');
            $mapping = $mapper->execute(new ParameterBag(array(
                'ids' => array_values(array_unique($ids)),
                'dbversion' => $this->connectionName
            )), null);
        } else {
            $mapper = $this->getContainer()->get('app.api.webservice')->factory('mapping', 'byDbxrefId');
            $mapping = $mapper->execute(new ParameterBag(array(
                'ids' => array_values(array_unique($ids)),
                'dbversion' => $this->connectionName,
                'db' => $method
            )), null);
        }
        return $mapping;
    }

}