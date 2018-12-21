<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\TextBlock;

use Doctrine\ORM\EntityManagerInterface;
use MKebza\Content\Entity\TextBlock;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class TextBlockCreator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * @var string
     */
    private $textBlockEntityClass;

    /**
     * TextBlockCreator constructor.
     */
    public function __construct(string $textBlockEntityClass, EntityManagerInterface $em, PropertyAccessorInterface $accessor = null)
    {
        $this->em = $em;
        $this->accessor = $accessor ?? PropertyAccess::createPropertyAccessor();
        $this->textBlockEntityClass = $textBlockEntityClass;
    }

    public function create(array $options): TextBlock
    {
        $block = new $this->textBlockEntityClass();
        foreach ($options as $k => $v) {
            $this->accessor->setValue($block, $k, $v);
        }

        $this->em->persist($block);
        $this->em->flush();

        return $block;
    }
}
