<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\ORM;

use Doctrine\ORM\Mapping as ORM;

trait ImageableMulti
{
    /**
     * @var Image
     *
     * @ORM\ManyToMany(targetEntity="MKebza\Content\ORM\ImageInterface")
     */
    private $images;

    /**
     * @return Image
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
     * @return Room
     */
    public function addImage(ImageInterface $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }
}
