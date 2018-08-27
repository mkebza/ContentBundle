<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('m_kebza_content');

        $rootNode
            ->children()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('gallery')->defaultTrue()->end()
                        ->booleanNode('text_block')->defaultTrue()->end()
                    ->end()
                ->end()
                ->arrayNode('entity')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('image')->defaultValue('App\\Entity\\Image')->end()
                        ->scalarNode('gallery')->defaultValue('App\\Entity\\Image')->end()
                        ->scalarNode('gallery_image')->defaultValue('App\\Entity\\Image')->end()
                        ->scalarNode('text_block')->defaultValue('App\\Entity\\Image')->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
