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

class QuestionAnswerCategoryAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'question-answer-category';
    protected $baseRouteName = 'question_answer_category';

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with(null)
                ->add('name', null, ['label' => 'QuestionAnswerCategory.field.name'])
                ->add('priority', null, ['label' => 'QuestionAnswerCategory.field.priority'])
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, ['label' => 'QuestionAnswerCategory.field.name'])
            ->add('priority', null, ['label' => 'QuestionAnswerCategory.field.priority'])
            ->add('created', null, ['label' => 'QuestionAnswerCategory.field.created'])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }
}
