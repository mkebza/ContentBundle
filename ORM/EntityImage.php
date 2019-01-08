<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\ORM;

use Doctrine\ORM\Mapping as ORM;

trait EntityImage
{
    /**
     * @var null|ImageInterface
     * @ORM\ManyToOne(targetEntity="MKebza\Content\ORM\ImageInterface", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $image;

    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    /**
     * @param Image $previewImage
     *
     * @return Room
     */
    public function setImage(?ImageInterface $image): self
    {
        $this->image = $image;

        return $this;
    }
}
