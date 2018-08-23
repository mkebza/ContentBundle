<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\Service\Fixture\Provider;

use Faker\Provider\Base;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFileProvider extends Base
{
    private $fixturesImageRoot;

    /**
     * ImageFileProvider constructor.
     *
     * @param $fixturesImageRoot
     */
    public function __construct(string $path)
    {
        $this->fixturesImageRoot = $path;
    }

    public function imageFile($fileName)
    {
        $path = $this->fixturesImageRoot.$fileName;
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

        return $uploadedFile;
    }
}
