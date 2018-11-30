<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Admin;

use MKebza\Content\Entity\TextBlock;
use MKebza\Content\Service\TextBlock\TextBlockTypeRegistry;
use MKebza\SonataExt\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            'sonata.admin.text_block.log' => [
                ['actions' => ['list'], 'items' => $baseWithReturn],
            ],
        ];
    }

    protected function configureFormFields(FormMapper $form)
    {
        /** @var TextBlock $block */
        $block = $this->getSubject();
        $form
            ->with(null)
                ->add('name', null, ['label' => 'TextBlock.field.name']);

        if ($this->isCreating() && !$this->textBlockTypeRegistry->isEmpty()) {
            $form->add('type', ChoiceType::class, [
                'label' => 'TextBlock.field.type',
                'choices' => ['----' => null] + $this->textBlockTypeRegistry->getChoices(),
            ]);
        }

        $form
                ->add('title', null, ['label' => 'TextBlock.field.title'])
                ->add('content', null, ['label' => 'TextBlock.field.content'])
            ->end();

        if ($block->getType()) {
            $type = $this->textBlockTypeRegistry->get($block->getType());

            $form
                ->with('TextBlock.panel.extra')
                    ->add('extra', ImmutableArrayType::class, [
                        'label' => false,
                        'keys' => $type->getFields($block),
                    ])
                ->end();
        }

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $form
                ->with('TextBlock.panel.developer', ['box_class' => 'box box-danger'])
                    ->add('key', null, ['label' => 'TextBlock.field.key'])
                ->end();
        }

//            ->add('extra', ImmutableArrayType::class, [])
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, ['label' => 'TextBlock.field.name']);

        if ($this->isGrantedSymfony('ROLE_DEVELOPER')) {
            $list
                ->add('key', null, ['label' => 'TextBlock.field.key'])
                ->add('type', null, ['label' => 'TextBlock.field.type']);
        }

        $list->add('_action', null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ],
        ]);
    }
}
