<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\Service\Page;

use MKebza\Content\Entity\Page;
use MKebza\Content\Exception\PageNotFoundException;
use MKebza\Content\Repository\PageRepository;

class PageRegistry
{
    /**
     * @var PageRepository
     */
    private $repository;

    /**
     * PageRegistry constructor.
     *
     * @param PageRepository $repository
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(string $key, $onlyActive = true): Page
    {
        $page = $this->repository->findOneBy(['key' => $key, 'active' => $onlyActive]);
        if (null === $page) {
            throw new PageNotFoundException(sprintf("Page '%s' not found", $key));
        }

        return $page;
    }
}
