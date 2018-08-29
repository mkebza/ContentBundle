<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Controller\Page;

use MKebza\Content\Entity\Page;
use MKebza\Content\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Templating\EngineInterface;

class ViewController extends AbstractController
{
    public function __invoke(string $slug, PageRepository $repository, EngineInterface $templating)
    {
        /** @var Page $page */
        $page = $repository->findOneBy(['slug' => $slug, 'active' => true]);
        if (null === $page) {
            throw new NotFoundHttpException();
        }

        $template = sprintf('frontend/page/%s.html.twig', $page->getKey() ? $page->getKey() : $page->getSlug());
        if (!$templating->exists($template)) {
            $template = '@MKebzaContent/page/view.html.twig';
        }

        return $this->render($template, [
            'page' => $page,
        ]);
    }
}
