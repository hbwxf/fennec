<?php

namespace Tests\AppBundle\Command;


use AppBundle\Command\ImportOrganismIDsCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ImportOrganismIDsCommandTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var CommandTester
     */
    private $commandTester;
    /**
     * @var Command
     */
    private $command;

    public function setUp()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new ImportOrganismIDsCommand());

        $this->command = $application->find('app:import-organism-ids');
        $this->commandTester = new CommandTester($this->command);
        $this->em = self::$kernel->getContainer()->get('app.orm')->getManagerForVersion('test');
    }

    public function testExecute()
    {
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'file' => __DIR__ . '/files/emptyFile.tsv'
        ));
        // the output of the command in the console
        $output = $this->commandTester->getDisplay();
        $this->assertContains('Importer', $output);
    }

    public function testImportFennecID(){
        $this->assertNull($this->em->getRepository('AppBundle:Db')->findOneBy(array(
            'name' => 'organismDBWithFennecIDProvider'
        )), 'before import there is no db named "organismDBWithFennecIDProvider"');
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'file' => __DIR__ . '/files/organismIDs_fennec_id.tsv',
            '--provider' => 'organismDBWithFennecIDProvider',
            '--description' => 'organismDBWithFennecIDDescription',
        ));
        $provider = $this->em->getRepository('AppBundle:Db')->findOneBy(array(
            'name' => 'organismDBWithFennecIDProvider'
        ));
        $this->assertNotNull($provider, 'after import there is a db named "organismDBWithFennecIDProvider"');
        $rbID = $this->em->getRepository('AppBundle:FennecDbxref')->findOneBy(array(
            'db' => $provider,
            'fennec' => 27
        ))->getIdentifier();
        $this->assertEquals($rbID, 2, 'The fennec id 27 has been linked to id 2');

    }

    public function testImportScientificName(){
        $this->assertNull($this->em->getRepository('AppBundle:Db')->findOneBy(array(
            'name' => 'organismDBWithScientificNameProvider'
        )), 'before import there is no db named "organismDBWithScientificNameProvider"');
        $this->commandTester->execute(array(
            'command' => $this->command->getName(),
            'file' => __DIR__ . '/files/organismIDs_scientificName.tsv',
            '--provider' => 'organismDBWithScientificNameProvider',
            '--description' => 'organismDBWithScientificNameDescription',
        ));
        $provider = $this->em->getRepository('AppBundle:Db')->findOneBy(array(
            'name' => 'organismDBWithScientificNameProvider'
        ));
        $this->assertNotNull($provider, 'after import there is a db named "organismDBWithScientificNameProvider"');
        $fennec = $this->em->getRepository("AppBundle:Organism")->findOneBy(array(
            'scientificName' => 'Coptosperma littorale'
        ));
        $rbID = $this->em->getRepository('AppBundle:FennecDbxref')->findOneBy(array(
            'db' => $provider,
            'fennec' => $fennec
        ))->getIdentifier();
        $this->assertEquals($rbID, 362, 'Coptosperma littorale has been linked to id 362');

    }

}