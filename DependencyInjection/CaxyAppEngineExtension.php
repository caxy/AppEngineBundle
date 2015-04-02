<?php

namespace Caxy\Bundle\AppEngineBundle\DependencyInjection;

use google\appengine\api\app_identity\AppIdentityService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CaxyAppEngineExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('app_identity.yml');
        $loader->load('console.yml');
        $loader->load('db.yml');
        $loader->load('mailer.yml');
        $loader->load('memcache.yml');
        $loader->load('security.yml');
        $loader->load('session.yml');

        $this->setAppIdentityParameters($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function setAppIdentityParameters(ContainerBuilder $container)
    {
        if (class_exists('google\appengine\api\app_identity\AppIdentityService')) {
            $container->setParameter('app_engine.application_id', AppIdentityService::getApplicationId());
            $container->setParameter('app_engine.default_version_hostname', AppIdentityService::getDefaultVersionHostname());
            $container->setParameter('app_engine.service_identity', AppIdentityService::getServiceAccountName());
        }
    }
}
