<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Admin;

use Knp\Menu\ItemInterface;
use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'gallery';
    protected $baseRouteName = 'admin_gallery';

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
                ['actions' => ['list', 'edit', 'create'], 'items' => $baseLevelWithParent]
            ],
        ];
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name', null, ['label' => 'Gallery.field.name']);

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list->add('key', null, ['label' => 'Gallery.field.key']);
        }

        $list->add('_action', null, ['actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }
}
