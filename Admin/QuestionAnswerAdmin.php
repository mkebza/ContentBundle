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
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QuestionAnswerAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'question-answer';
    protected $baseRouteName = 'question_answer';

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
            'sonata.admin.question_answer.log' => [
                ['actions' => ['list'], 'items' => $baseWithReturn],
            ],
        ];
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with(null)
                ->add('question', TextareaType::class)
                ->add('answer', TextareaType::class)
                ->add('categories')
                ->add('priority')
                ->add('active')
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('question')
            ->add('categories', null, ['associated_property' => 'name'])
            ->add('active', 'boolean', ['editable' => true])
            ->add('priority')
            ->add('created')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }
}
