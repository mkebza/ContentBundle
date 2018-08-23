<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\DependencyInjection\CompilerPass;

use MKebza\Content\ORM\ImageInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AutoResolveTargetEntitiesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $def = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');

        $def->addMethodCall('addResolveTargetEntity', [
            ImageInterface::class,
            $container->getParameter('mkebza_content.entity.image'),
            [],
        ]);

        $def->addTag('doctrine.event_subscriber');
    }
}
