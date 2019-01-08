<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\Service\Image;

use MKebza\Content\ORM\ImageInterface;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageCreator
{
    /**
     * @var string
     */
    private $imageEntityClass;

    /**
     * ImageCreator constructor.
     *
     * @param string $imageEntityClass
     */
    public function __construct(string $imageEntityClass)
    {
        $this->imageEntityClass = $imageEntityClass;
    }

    public function fromPath(string $path, ?string $name = null): ImageInterface
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('Unable to load file from path %s', $path));
        }

        $fileInfo = new \SplFileInfo($path);

        $mimeTypeGuesser = MimeTypeGuesser::getInstance();
        $uploadedFile = new UploadedFile(
            $fileInfo->getRealPath(),
            $fileInfo->getBasename(),
            $mimeTypeGuesser->guess($fileInfo->getRealPath()),
            $fileInfo->getSize(),
            null,
            true
        );

        $image = new $this->imageEntityClass();
        $image
            ->setImage($uploadedFile)
            ->setName($name);

        return $image;
    }
}
