<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MKebzaContentExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $container->setParameter('mkebza_content.entity.image', $config['entity']['image']);
        $container->setParameter('mkebza_content.entity.gallery', $config['entity']['gallery']);
        $container->setParameter('mkebza_content.entity.gallery_image', $config['entity']['gallery_image']);
        $container->setParameter('mkebza_content.entity.text_block', $config['entity']['text_block']);
        $container->setParameter('mkebza_content.entity.page', $config['entity']['page']);

        $loader->load('services.yaml');

        // Include registered admins
        foreach ($config['admin'] as $name => $enabled) {
            if ($enabled) {
                $loader->load('admin/'.$name.'.yaml');
            }
        }
    }
}
