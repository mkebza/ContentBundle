<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Twig\Runtime;

use Doctrine\ORM\EntityManagerInterface;
use MKebza\Content\Repository\PageRepository;
use Twig\Extension\RuntimeExtensionInterface;

class PageRuntime implements RuntimeExtensionInterface
{
    /**
     * @var PageRepository
     */
    private $repository;

    /**
     * PageRuntime constructor.
     */
    public function __construct(string $pageEntityClass, EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository($pageEntityClass);
    }

    public function get(string $key)
    {
        return $this->repository->findOneBy(['key' => $key]);
    }
}
