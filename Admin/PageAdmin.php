<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Admin;

use MKebza\Content\Entity\Page;
use MKebza\Content\Service\Page\PageTypeRegistry;
use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PageAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'page';
    protected $baseRouteName = 'admin_page';

    /**
     * @var PageTypeRegistry
     */
    protected $pageTypeRegistry;

    /**
     * @param PageTypeRegistry $pageTypeRegistry
     */
    public function setPageTypeRegistry(PageTypeRegistry $pageTypeRegistry): void
    {
        $this->pageTypeRegistry = $pageTypeRegistry;
    }

    public function getTabMenuMap(): array
    {
        $baseLevel = [$this->createLogTabMenuItem()];
        $baseWithReturn = array_merge([$this->createParentTabMenuItem()], $baseLevel);

        return [
            self::class => [
                [
                    'actions' => ['edit'],
                    'items' => [$this->createLogTabMenuItem()],
                ],
            ],
            'sonata.admin.page.log' => [
                ['actions' => ['list'], 'items' => $baseWithReturn],
            ],
        ];
    }

    protected function configureFormFields(FormMapper $form)
    {
        /** @var Page $block */
        $block = $this->getSubject();
        $form
            ->with(null)
                ->add('name', null, ['label' => 'Page.field.name']);

        if ($this->isCreating() && !$this->pageTypeRegistry->isEmpty()) {
            $form->add('type', ChoiceType::class, [
                'label' => 'Page.field.type',
                'choices' => ['----' => null] + $this->pageTypeRegistry->getChoices(),
            ]);
        }

        $form
                ->add('active', null, ['label' => 'Page.field.active'])
                ->add('title', null, ['label' => 'Page.field.title'])
                ->add('content', null, ['label' => 'Page.field.content'])
            ->end();

        if ($block->getType()) {
            $type = $this->pageTypeRegistry->get($block->getType());

            $form
                ->with('Page.panel.extra')
                    ->add('extra', ImmutableArrayType::class, [
                        'label' => false,
                        'keys' => $type->getFields($block),
                    ])
                ->end();
        }

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $form
                ->with('Page.panel.developer', ['box_class' => 'box box-danger'])
                    ->add('key')
                ->end();
        }
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, ['label' => 'Page.field.name'])
            ->add('active', null, [
                'editable' => true,
                'label' => 'Page.field.active'
            ]);

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list
                ->add('key', null, ['label' => 'Page.field.key'])
                ->add('type', null, ['label' => 'Page.field.type']);
        }

        $list->add('_action', null, [
            'actions' => [
                'edit' => [],
                'frontend_view' => ['template' => '@MKebzaContent/page/list/action_frontend_view.html.twig'],
                'delete' => [],
            ],
        ]);
    }
}
