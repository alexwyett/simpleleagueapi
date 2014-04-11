<?php

namespace AW\SimpleLeagueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to clear the database
 *
 * @category  Commands
 * @package   AW
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
class TruncateSchemaCommand extends ContainerAwareCommand
{
    /**
     * (non-PHPdoc)
     * 
     * @see \Symfony\Component\Console\Command\Command::configure()
     * 
     * @return void
     */
    protected function configure()
    {
        $this->setName('simpleleague:truncate')
            ->setDescription('Truncates the db')
            ->setHelp(<<<EOT
The <info>simpleleague:truncate</info> truncates the db
EOT
            );
    }

    /**
     * (non-PHPdoc)
     * 
     * @param Symfony\Component\Console\Input\InputInterface  $input  In
     * @param Symfony\Component\Console\Input\OutputInterface $output Out
     * 
     * @see \Symfony\Component\Console\Command\Command::execute()
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $em = $this->getContainer()->get('doctrine')->getManager();
            $connection = $em->getConnection();
            $platform = $connection->getDatabasePlatform();
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
            
            $tables = array(
                'LeagueUserClub',
                'LeagueUser',
                'Activity',
                'Score',
                'LeagueMatch',
                'LeagueMatchTeam',
                'Team',
                'Club',
                'Season',
                'League'
            );
            foreach ($tables as $table) {
                $sql = $platform->getTruncateTableSql($table);
                $connection->executeUpdate($sql);
            }
            $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
            
            
        } catch (\Exception $ex) {
            $output->writeln(
                sprintf(
                    '<comment>%s</comment>',
                    $ex->getMessage()
                )
            );
        }
    }
}