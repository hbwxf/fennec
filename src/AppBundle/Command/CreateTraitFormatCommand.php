<?php

namespace AppBundle\Command;


use AppBundle\Entity\Data\TraitFormat;
use AppBundle\Service\DBVersion;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTraitFormatCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:create-traitformat')

        // the short description shown while running "php bin/console list"
        ->setDescription('Creates new TraitFormat.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("This command allows you to create trait types...")
        ->addArgument('format', InputArgument::REQUIRED, 'The name of the new trait format')
        ->addOption('connection', 'c', InputOption::VALUE_REQUIRED, 'The database version')
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'TraitFormat Creator',
            '===================',
            '',
        ]);
        $connection_name = $input->getOption('connection');
        if($connection_name == null) {
            $connection_name = $this->getContainer()->get('doctrine')->getDefaultConnectionName();
        }
        $em = $this->getContainer()->get(DBVersion::class)->getDataEntityManager();
        $format = $em->getRepository('AppBundle:TraitFormat')->findOneBy(['format' => $input->getArgument('format')]);
        if($format != null){
            $output->writeln('<info>TraitFormat already exists, nothing to do.</info>');
            $output->writeln('<info>TraitFormat ID is: '.$format->getId().'</info>');
            return;
        }
        $traitFormat = new TraitFormat();
        $traitFormat->setFormat($input->getArgument('format'));
        $em->persist($traitFormat);
        $em->flush();
        $output->writeln('<info>TraitFormat successfully created: '.$traitFormat->getFormat().'</info>');
        $output->writeln('<info>TraitFormat ID is: '.$traitFormat->getId().'</info>');
    }
}