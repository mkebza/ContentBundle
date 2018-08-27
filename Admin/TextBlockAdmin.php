<?php

declare(strict_types=1);


namespace MKebza\Content\Admin;


use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;

class TextBlockAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'block';
    protected $baseRouteName = 'admin_text_block';

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
            ->add('title')
            ->add('content');
//            ->add('extra', ImmutableArrayType::class, [])
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name');
    }


}