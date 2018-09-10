<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Entity;

use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\ORM\EntityId;
use MKebza\SonataExt\ORM\EntityKey;
use MKebza\SonataExt\ORM\Logger\Loggable;
use MKebza\SonataExt\ORM\Logger\LoggableInterface;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;

/**
 * Class TextBlock.
 *
 * @ORM\MappedSuperclass()
 */
class TextBlock implements LoggableInterface
{
    use EntityId, EntityKey, Loggable, Timestampable;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $name;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $title;

    /**
     * @var null|string
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $type;

    /**
     * @var null|array
     * @ORM\Column(type="json", nullable=true)
     */
    private $extra;

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     *
     * @return TextBlock
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     *
     * @return TextBlock
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param null|string $content
     *
     * @return TextBlock
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @param null|array $extra
     *
     * @return TextBlock
     */
    public function setExtra(?array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}
