<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\ORM\IdAble;
use MKebza\SonataExt\ORM\Timestampable\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\MappedSuperclass()
 * @Vich\Uploadable
 */
class Image
{
    use IdAble, Timestampable;

    /**
     * @ORM\Column(name="name", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="mime_type", nullable=true)
     */
    protected $mime;

    /**
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    protected $size;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $width;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $height;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="image",
     *     fileNameProperty="fileName",
     *     size="size",
     *     originalName="name",
     *     mimeType="mime",
     *     dimensions="dimensions"
     * )
     *
     * @var File
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $fileName;

    /**
     * Image constructor.
     */
    public function __construct()
    {
        $this->createdAt = Carbon::now();
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImage(?File $image = null): void
    {
        $this->image = $image;

        /*
         * @TOOD Need to update this for some other field
         *        if (null !== $image) {
         *            // It is required that at least one field changes if you are using doctrine
         *            // otherwise the event listeners won't be called and the file is lost
         *            $this->updatedAt = new \DateTimeImmutable();
         *        }
         */
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     *
     * @return Product
     */
    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @param mixed $mime
     *
     * @return Product
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     *
     * @return Product
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param mixed $dimensions
     *
     * @return Product
     */
    public function setDimensions($dimensions)
    {
        $this
            ->setWidth($dimensions[0])
            ->setHeight($dimensions[1]);

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return Image
     */
    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return Image
     */
    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
}
