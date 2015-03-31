<?php

namespace Caxy\Bundle\AppEngineBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('appengine:cache:clear');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = $this->getContainer()->get('google.storage.service');
        $bucketId = $this->getContainer()->getParameter('app_engine.default_bucket_name');

        /** @var \Google_Service_Storage_Objects $objects */
        $objects = $service->objects->listObjects($bucketId, array('prefix' => 'var/cache'));

        /** @var \Google_Service_Storage_StorageObject $object */
        foreach ($objects->getItems() as $object) {
            $output->writeln('Deleting '.$object->getName());
            $service->objects->delete($bucketId, $object->getName());
        }
    }
}
