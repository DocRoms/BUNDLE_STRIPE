<?php

namespace docroms\Bundle\PaymentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('paiement');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
            ->scalarNode('paypalMode')->defaultValue('sandbox')->end()
            ->scalarNode('paypalIdentifiant')->defaultValue('')->end()
            ->scalarNode('paypalUserApi')->defaultValue('')->end()
            ->scalarNode('paypalUserPassApi')->defaultValue('')->end()
            ->scalarNode('paypalSignature')->defaultValue('')->end()
            ->scalarNode('paypalClientId')->defaultValue('')->end()
            ->scalarNode('paypalSecret')->defaultValue('')->end()
            ->scalarNode('stripeTestSecretKey')->defaultValue('')->end()
            ->scalarNode('stripeTestPublishableKey')->defaultValue('')->end()
            ->scalarNode('stripeToken')->defaultValue('')->end();

        return $treeBuilder;
    }
}
