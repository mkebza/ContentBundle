<?php

declare(strict_types=1);


namespace MKebza\Content\Twig\Extension;


use MKebza\Content\Twig\Runtime\OpenGraphRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class OpenGraphExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'open_graph',
                [OpenGraphRuntime::class, 'openGraph'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

}