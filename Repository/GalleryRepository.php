<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use MKebza\Content\Entity\Gallery;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GalleryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, string $galleryEntityClass)
    {
        parent::__construct($registry, $galleryEntityClass);
    }

    public function getByKey(string $key): ?Gallery
    {
        return $this->createQueryBuilder('gallery')
            ->select('gallery')
            ->where('gallery.key = :key')
            ->setParameter('key', $key)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
