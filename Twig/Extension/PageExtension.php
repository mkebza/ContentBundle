<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Twig\Extension;

use MKebza\Content\Twig\Runtime\PageRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PageExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('page_get', [PageRuntime::class, 'get']),
        ];
    }
}
