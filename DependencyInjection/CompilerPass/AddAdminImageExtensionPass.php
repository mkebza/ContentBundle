<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\DependencyInjection\CompilerPass;

use MKebza\Content\Service\Image\AdminImageExtension;
use MKebza\Content\Service\Image\AdminImageInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddAdminImageExtensionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $admins = $container->findTaggedServiceIds('sonata.admin');

        foreach ($admins as $id => $extra) {
            $definition = $container->getDefinition($id);

            if ((new \ReflectionClass($definition->getClass()))->implementsInterface(AdminImageInterface::class)) {
                $definition->addMethodCall('addExtension', [new Reference(AdminImageExtension::class)]);
            }
        }
    }
}
