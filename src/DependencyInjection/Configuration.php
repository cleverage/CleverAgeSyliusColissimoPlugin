<?php

namespace CleverAge\SyliusColissimoPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('clever_age_sylius_colissimo');

        $rootNode = $builder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('encryptionKey')->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $builder;
    }
}
