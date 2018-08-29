<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\Page;

class PageTypeRegistry
{
    /**
     * @var iterable|PageTypeInterface[]
     */
    private $types;

    /**
     * @param $types
     */
    public function __construct(iterable $types)
    {
        $this->types = [];
        foreach ($types as $type) {
            $this->add($type);
        }
    }

    public function add(PageTypeInterface $type): void
    {
        $this->types[$type->getAlias()] = $type;
    }

    public function get(string $alias): PageTypeInterface
    {
        return $this->types[$alias];
    }

    public function isEmpty(): bool
    {
        return empty($this->types);
    }

    public function count(): int
    {
        return count($this->types);
    }

    public function getChoices(): array
    {
        $choices = [];
        foreach ($this->types as $type) {
            $choices[$type->getName()] = $type->getAlias();
        }

        return $choices;
    }
}
