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
use Doctrine\ORM\Mapping as ORM;
use MKebza\Content\ORM\EntityImage;
use MKebza\Content\ORM\EntityImageMany;
use MKebza\SonataExt\ORM\EntityActive;
use MKebza\SonataExt\ORM\EntityId;
use MKebza\SonataExt\ORM\EntityKey;
use MKebza\SonataExt\ORM\Sluggable\EntitySluggable;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;

/**
 * Class Gallery.
 *
 * @ORM\MappedSuperclass()
 */
abstract class Gallery
{
    use EntityId, EntityKey, EntityActive, EntityImage, EntitySluggable, EntityImageMany, Timestampable;

    /**
     * @var null|string
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
     *
     * @return Gallery
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
