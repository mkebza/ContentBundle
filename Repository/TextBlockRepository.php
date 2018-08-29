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
use MKebza\Content\Entity\TextBlock;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TextBlockRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, string $textBlockEntityClass)
    {
        parent::__construct($registry, $textBlockEntityClass);
    }

    public function getByKey(string $key): ?TextBlock
    {
        return $this->createQueryBuilder('block')
            ->select('block')
            ->where('block.key = :key')
            ->setParameter('key', $key)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
