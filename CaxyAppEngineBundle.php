<?php

namespace Caxy\Bundle\AppEngineBundle;

use Caxy\Bundle\AppEngineBundle\Security\Factory\AppEngineFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CaxyAppEngineBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new AppEngineFactory());
    }
}
