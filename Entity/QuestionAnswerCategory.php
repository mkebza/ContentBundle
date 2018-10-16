<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\ORM\EntityId;
use MKebza\SonataExt\ORM\EntityPrioritizable;
use MKebza\SonataExt\ORM\Sluggable\EntitySluggable;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;

/**
 * Class QuestionAnswerCategory.
 *
 * @ORM\MappedSuperclass()
 */
class QuestionAnswerCategory
{
    use EntityId, EntitySluggable, Timestampable, EntityPrioritizable;

    /**
     * @var Collection|QuestionAnswer
     * @ORM\ManyToMany(targetEntity="MKebza\Content\Entity\QuestionAnswer", mappedBy="categories")
     */
    protected $questions;

    /**
     * @return Collection|QuestionAnswer
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }
}
