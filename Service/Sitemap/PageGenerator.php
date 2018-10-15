<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\Sitemap;

use App\Entity\Content\Page;
use MKebza\Content\Repository\PageRepository;
use MKebza\Sitemap\Service\Location;
use MKebza\Sitemap\Service\SitemapLocationGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class PageGenerator implements SitemapLocationGeneratorInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PageRepository
     */
    private $repository;

    /**
     * PageGenerator constructor.
     *
     * @param RouterInterface $router
     * @param PageRepository  $repository
     */
    public function __construct(RouterInterface $router, PageRepository $repository)
    {
        $this->router = $router;
        $this->repository = $repository;
    }

    public function generate(): \Generator
    {
        /** @var Page $page */
        foreach ($this->repository->findBy(['active' => true]) as $page) {
            yield new Location($this->router->generate('page_view', ['slug' => $page->getSlug()]), $page->getUpdated());
        }
    }
}
