<?php

declare(strict_types=1);


namespace MKebza\Content\Twig\Extension;


use MKebza\Content\Twig\Runtime\TextBlockRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TextBlockExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('text_block', [TextBlockRuntime::class, 'get']),
        ];
    }
}