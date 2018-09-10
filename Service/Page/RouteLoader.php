<?php

declare(strict_types=1);


namespace MKebza\Content\Service\Page;


use App\Entity\Content\Page;
use MKebza\Content\Controller\Page\ViewController;
use MKebza\Content\Repository\PageRepository;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteLoader
{
    /**
     * @var PageRepository
     */
    private $repository;

    /**
     * RouteLoader constructor.
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load(): RouteCollection
    {
        $collection = new RouteCollection();

        /** @var Page $page */
        foreach ($this->repository->findAll() as $page) {
            $collection->add(
                'page_view_'.$page->getKey(),
                new Route('/page/'.$page->getSlug(), ['controller' => ViewController::class])
            );
        }


        return $collection;
    }
}