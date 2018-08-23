<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\Admin;

use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'image';
    protected $baseRouteName = 'admin_image';

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
    }

    protected function configureFormFields(FormMapper $form)
    {
        parent::configureFormFields($form);

        if ($this->isCreating()) {
            $form->add('imageFile', VichImageType::class);
        } else {
            $form
                ->tab('word.general')
                    ->with(null)
                        ->add('name')
                    ->end()
                ->end();
        }
    }
}
