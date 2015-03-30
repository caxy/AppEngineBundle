<?php

namespace Caxy\Bundle\AppEngineBundle\Security\UserProvider;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\UserProvider\UserProviderFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class AppEngineFactory implements UserProviderFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config)
    {
        $definition = $container->setDefinition($id, new DefinitionDecorator('app_engine.provider.user'));
        $definition->replaceArgument(0, $config['grant_user_role']);
        $definition->replaceArgument(1, $config['grant_admin_role']);
    }

    public function getKey()
    {
        return 'app_engine';
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('grant_admin_role')
                    ->prototype('scalar')->end()
                    ->defaultValue(array('ROLE_SUPER_ADMIN'))
                ->end()
                ->arrayNode('grant_user_role')
                    ->prototype('scalar')->end()
                    ->defaultValue(array('ROLE_USER'))
                ->end()
            ->end()
        ;
    }
}
