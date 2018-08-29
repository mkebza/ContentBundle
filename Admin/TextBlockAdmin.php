<?php

declare(strict_types=1);


namespace MKebza\Content\Admin;


use MKebza\Content\Entity\TextBlock;
use MKebza\Content\Service\TextBlock\TextBlockTypeRegistry;
use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TextBlockAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'block';
    protected $baseRouteName = 'admin_text_block';


    /**
     * @var TextBlockTypeRegistry
     */
    protected $textBlockTypeRegistry;

    /**
     * @param TextBlockTypeRegistry $textBlockTypeRegistry
     */
    public function setTextBlockTypeRegistry(TextBlockTypeRegistry $textBlockTypeRegistry): void
    {
        $this->textBlockTypeRegistry = $textBlockTypeRegistry;
    }

    protected function configureFormFields(FormMapper $form)
    {
        /** @var TextBlock $block */
        $block = $this->getSubject();
        $form
            ->with(null)
                ->add('name');

        if ($this->isCreating()) {
            $form->add('type', ChoiceType::class, [

                'choices' => ['----' => null] + $this->textBlockTypeRegistry->getChoices(),

            ]);
        }

        $form
                ->add('title')
                ->add('content')
            ->end();

        if ($block->getType()) {
            $type = $this->textBlockTypeRegistry->get($block->getType());

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

//            ->add('extra', ImmutableArrayType::class, [])
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name');

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list
                ->add('key')
                ->add('type');
        }

        $list->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}