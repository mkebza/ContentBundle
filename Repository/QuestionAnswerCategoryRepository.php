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
use Symfony\Bridge\Doctrine\RegistryInterface;

class QuestionAnswerCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, string $questionAnswerCategoryEntityClass)
    {
        parent::__construct($registry, $questionAnswerCategoryEntityClass);
    }
}
