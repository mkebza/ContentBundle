<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\Gallery;

use Doctrine\ORM\EntityManagerInterface;
use MKebza\Content\Entity\Gallery;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class GalleryCreator
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
    private $galleryEntityClass;

    /**
     * TextBlockCreator constructor.
     */
    public function __construct(string $galleryEntityClass, EntityManagerInterface $em, PropertyAccessorInterface $accessor = null)
    {
        $this->em = $em;
        $this->accessor = $accessor ?? PropertyAccess::createPropertyAccessor();
        $this->galleryEntityClass = $galleryEntityClass;
    }

    public function create(array $options): Gallery
    {
        $block = new $this->galleryEntityClass();
        foreach ($options as $k => $v) {
            $this->accessor->setValue($block, $k, $v);
        }

        $this->em->persist($block);
        $this->em->flush();

        return $block;
    }
}
