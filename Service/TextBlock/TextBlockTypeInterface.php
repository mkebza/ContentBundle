<?php

declare(strict_types=1);


namespace MKebza\Content\Service\TextBlock;


interface TextBlockTypeInterface
{
    public function getAlias(): string;
    public function getName(): string;
    public function getFields(): array;
}