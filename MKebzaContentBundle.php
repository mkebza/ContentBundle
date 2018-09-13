<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content;

use MKebza\Content\DependencyInjection\CompilerPass\AddAdminImageExtensionPass;
use MKebza\Content\DependencyInjection\CompilerPass\AutoResolveTargetEntitiesPass;
use MKebza\Content\Service\TextBlock\TextBlockTypeInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MKebzaContentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            new AutoResolveTargetEntitiesPass(),
            PassConfig::TYPE_BEFORE_OPTIMIZATION,
            100);

        $container->addCompilerPass(new AddAdminImageExtensionPass());

        $container
            ->registerForAutoconfiguration(TextBlockTypeInterface::class)
            ->addTag('mkebza_content.text_block_type');
    }
}
