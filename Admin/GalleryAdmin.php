<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Admin;

use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'gallery';
    protected $baseRouteName = 'admin_gallery';

    public function getTabMenuMap(): array
    {
        $baseLevel = [
            $this->createTabMenuItem('Gallery.menu.images', 'admin_gallery_image_list', ['id'], 'th'),
        ];

        $baseLevelWithParent = array_merge(
            [$this->createParentTabMenuItem()],
            $baseLevel
        );

        return [
            self::class => [['actions' => ['edit'], 'items' => $baseLevel]],

            'sonata.admin.gallery.image' => [
                ['actions' => ['list', 'edit', 'create'], 'items' => $baseLevelWithParent],
            ],
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name', null, ['label' => 'Gallery.field.name'])
            ->add('active', null, ['label' => 'Gallery.field.active'])
        ;

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $filter->add('key', null, ['label' => 'Gallery.field.key']);
        }
    }


    protected function configureFormFields(FormMapper $form)
    {
        parent::configureFormFields($form);

        $form
            ->with(null)
                ->add('name', null, ['label' => 'Gallery.field.name'])
                ->add('description', null, ['label' => 'Gallery.field.description'])
                ->add('active', null, ['label' => 'Gallery.field.active'])
            ->end();

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $form
                ->with('Developer', ['box_class' => 'box box-danger'])
                    ->add('key', null, ['label' => 'Gallery.field.key'])
                ->end()
            ;
        }
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, ['label' => 'Gallery.field.name'])
            ->add('active', null, ['label' => 'Gallery.field.active', 'editable' => true])
        ;

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list->add('key', null, ['label' => 'Gallery.field.key']);
        }

        $list->add('_action', null, ['actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }
}
