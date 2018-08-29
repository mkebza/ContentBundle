<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\ORM;

use Doctrine\Common\Collections\ArrayCollection;

trait EntityImageMany
{
    /**
     * @var Image
     */
    protected $images;

    /**
     * @return Image[]|ArrayCollection
     */
    public function getImages(): iterable
    {
        return $this->images;
    }

    /**
     * @param Image $images
     *
     * @return Room
     */
    public function setImages(iterable $images): self
    {
        foreach ($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * @param Image $image
     *
     * @return
     */
    public function addImage(ImageInterface $image): self
    {
        if (!$this->images->contains($image)) {
            $image->setReference($this);
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(ImageInterface $image): self
    {
        $this->images->remove($image);

        return $this;
    }

    abstract public static function getImagesEntityFQN(): string;
}
