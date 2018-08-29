<?php

declare(strict_types=1);


namespace MKebza\Content\Entity;

use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\ORM\EntityId;
use MKebza\SonataExt\ORM\EntityKey;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;

/**
 * Class TextBlock
 * @package MKebza\Content\Entity
 *
 * @ORM\MappedSuperclass()
 */
class TextBlock
{
    use EntityId, EntityKey, Timestampable;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    private $type;

    /**
     * @var array|null
     * @ORM\Column(type="json", nullable=true)
     */
    private $extra;

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return TextBlock
     */
    public function setName(?string $name): TextBlock
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
     * @return TextBlock
     */
    public function setTitle(?string $title): TextBlock
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
     * @return TextBlock
     */
    public function setContent(?string $content): TextBlock
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @param array|null $extra
     * @return TextBlock
     */
    public function setExtra(?array $extra): TextBlock
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

    public function __toString()
    {
        return (string)$this->getName();
    }


}