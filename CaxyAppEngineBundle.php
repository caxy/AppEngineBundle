<?php

namespace Caxy\Bundle\AppEngineBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CaxyAppEngineBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new Security\Factory\AppEngineFactory());
        $extension->addUserProviderFactory(new Security\UserProvider\AppEngineFactory());
    }
}
