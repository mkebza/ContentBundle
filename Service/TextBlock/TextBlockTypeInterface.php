<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\TextBlock;

interface TextBlockTypeInterface
{
    public function getAlias(): string;

    public function getName(): string;

    public function getFields(): array;
}
