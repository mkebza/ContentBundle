<?php

declare(strict_types=1);


namespace MKebza\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MKebza\Content\ORM\EntityImage;
use MKebza\Content\ORM\EntityImageMany;
use MKebza\SonataExt\ORM\EntityActive;
use MKebza\SonataExt\ORM\EntityId;
use MKebza\SonataExt\ORM\EntityKey;
use MKebza\SonataExt\ORM\Sluggable\Sluggable;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;

/**
 * Class Gallery
 * @package MKebza\Content\Entity
 * @ORM\MappedSuperclass()
 */
abstract class Gallery
{
    use EntityId, EntityKey, EntityActive, EntityImage, Sluggable, EntityImageMany, Timestampable;


    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * Gallery constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Gallery
     */
    public function setDescription(?string $description): Gallery
    {
        $this->description = $description;

        return $this;
    }
}