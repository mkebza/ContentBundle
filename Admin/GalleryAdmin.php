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
                ->add('name')
                ->add('description')
                ->add('active')
            ->end();

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $form
                ->with('Developer', ['box_class' => 'box box-danger'])
                    ->add('key')
                ->end()
            ;
        }
    }

    protected function configureTabMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        // For root admin, we are at listing skip
        if (!$childAdmin && !in_array($action, ['edit', 'show'], true)) {
            return;
        }

        $currentAdmin = $this->getCurrentLeafChildAdmin();

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        if (null !== $currentAdmin && $this->isGranted('EDIT')) {
            $menu
                ->addChild('Parent', [
                    'uri' => $admin->generateUrl('edit', ['id' => $id]),
                ])
                ->setAttribute('icon', 'fa fa-chevron-left');
        }

        if ($this->isGranted('LIST')) {
            $menu
                ->addChild('Images', [
                    'route' => 'admin_gallery_image_list',
                    'routeParameters' => ['id' => $id],
                ])
                ->setAttribute('icon', 'fa fa-image');
        }
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list->add('key');
        }

        $list->add('_action', null, ['actions' => [
            'edit' => [],
            'delete' => [],
        ]]);
    }
}
