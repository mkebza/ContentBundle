<?php

declare(strict_types=1);

namespace MKebza\Content\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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