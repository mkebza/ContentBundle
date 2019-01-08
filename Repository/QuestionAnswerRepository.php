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
use MKebza\Content\Entity\QuestionAnswer;
use MKebza\Content\Entity\QuestionAnswerCategory;
use Symfony\Bridge\Doctrine\RegistryInterface;

class QuestionAnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, string $questionAnswerEntityClass)
    {
        parent::__construct($registry, $questionAnswerEntityClass);
    }

    /**
     * Returns all active questions grouped by categories ordered by prioritites.
     *
     * @throws \Doctrine\ORM\Query\QueryException
     *
     * @return array
     */
    public function findAllGroupedByCategory(bool $includeEmpty = false)
    {
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from(QuestionAnswerCategory::class, 'c')
            ->indexBy('c', 'c.id')
            ->orderBy('c.priority', 'ASC')
            ->getQuery()
            ->getResult()
        ;
        $result = array_map(function (QuestionAnswerCategory $qac) { return ['category' => $qac, 'questions' => []]; }, $result);

        /** @var QuestionAnswer[] $questions */
        $questions = $this->findBy(['active' => true], ['priority' => 'ASC']);
        foreach ($questions as $question) {
            foreach ($question->getCategories() as $category) {
                $result[$category->getId()]['questions'][] = $question;
            }
        }

        if (!$includeEmpty) {
            $result = array_filter($result, function ($v) {
                return !empty($v['questions']);
            });
        }

        return $result;
    }
}
