<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Event;

use MKebza\Content\Entity\Page;
use Symfony\Component\EventDispatcher\Event;

final class PageRenderEvent extends Event
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var Page
     */
    private $page;

    /**
     * PageRenderEvent constructor.
     *
     * @param array $data
     * @param Page  $page
     */
    public function __construct(Page $page, array $data)
    {
        $this->data = $data;
        $this->page = $page;
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return PageRenderEvent
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function mergeData(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }
}
