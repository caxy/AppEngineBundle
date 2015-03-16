<?php

namespace Caxy\Bundle\AppEngineBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class CreateSessionSchemaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('appengine:schema:session')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dsn = $this->getContainer()->getParameter('app_engine.default_database_dsn');
        $username = $this->getContainer()->getParameter('database_user');
        $password = $this->getContainer()->getParameter('database_password');
        $storage = new PdoSessionHandler($dsn, array('db_username' => $username, 'db_password' => $password));
        $storage->createTable();
        $output->write('Created session table.');
    }
}
