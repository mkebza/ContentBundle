<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Repository;

use App\Entity\Content\GalleryImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use MKebza\Content\Entity\Gallery;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GalleryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, string $galleryEntityClass)
    {
        parent::__construct($registry, $galleryEntityClass);
    }

    public function getRandomImage(string $key, bool $active = true): ?GalleryImage
    {
        $images = $this->getRandomImages($key, 1, $active);

        return 0 === count($images) ? null : array_pop($images);
    }

    public function getRandomImages(string $key, int $limit = 10, bool $active = true): array
    {
        $gallery = $this->createQueryBuilder('gallery')
            ->select('gallery')
            ->leftJoin('gallery.image', 'image', 'WITH')
            ->where('gallery.key = :key AND gallery.active = :active')
            ->setParameter('key', $key)
            ->setParameter('active', $active)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $gallery || 0 === $gallery->getImages()->count()) {
            return [];
        }

        $images = $gallery->getImages()->toArray();
        shuffle($images);

        return array_slice($images, 0, $limit);
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
