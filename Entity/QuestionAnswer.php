<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\ORM\EntityActive;
use MKebza\SonataExt\ORM\EntityId;
use MKebza\SonataExt\ORM\EntityPrioritizable;
use MKebza\SonataExt\ORM\Logger\Loggable;
use MKebza\SonataExt\ORM\Logger\LoggableInterface;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class QuestionAnswer.
 *
 * @ORM\MappedSuperclass()
 */
class QuestionAnswer implements LoggableInterface
{
    use EntityId, EntityActive, EntityPrioritizable, Timestampable, Loggable;

    /**
     * @var Collection|QuestionAnswerCategory[]
     * @ORM\ManyToMany(targetEntity="MKebza\Content\Entity\QuestionAnswerCategory", inversedBy="questions")
     */
    protected $categories;

    /**
     * @var null|string
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $question;

    /**
     * @var null|string
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $answer;

    /**
     * QuestionAnswer constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getQuestion();
    }

    /**
     * @return null|string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param null|string $question
     *
     * @return QuestionAnswer
     */
    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param null|string $answer
     *
     * @return QuestionAnswer
     */
    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return Collection|QuestionAnswerCategory[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function addCategory(QuestionAnswerCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(QuestionAnswerCategory $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }
}
