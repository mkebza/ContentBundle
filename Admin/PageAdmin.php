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

    protected function configureFormFields(FormMapper $form)
    {
        /** @var Page $block */
        $block = $this->getSubject();
        $form
            ->with(null)
                ->add('name');

        if ($this->isCreating() && !$this->pageTypeRegistry->isEmpty()) {
            $form->add('type', ChoiceType::class, [
                'choices' => ['----' => null] + $this->pageTypeRegistry->getChoices(),
            ]);
        }

        $form
                ->add('active')
                ->add('title')
                ->add('content')
            ->end();

        if ($block->getType()) {
            $type = $this->pageTypeRegistry->get($block->getType());

            $form
                ->with('Extra')
                    ->add('extra', ImmutableArrayType::class, [
                        'label' => false,
                        'keys' => $type->getFields($block),
                    ])
                ->end();
        }

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $form
                ->with('Developer', ['box_class' => 'box box-danger'])
                    ->add('key')
                ->end();
        }
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('active', null, ['editable' => true]);

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list
                ->add('key')
                ->add('type');
        }

        $list->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ],
        ]);
    }
}
