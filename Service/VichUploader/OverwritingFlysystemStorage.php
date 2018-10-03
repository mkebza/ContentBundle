<?php

declare(strict_types=1);


namespace MKebza\Content\Service\VichUploader;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Storage\FlysystemStorage;

class OverwritingFlysystemStorage extends FlysystemStorage
{
    protected function doUpload(PropertyMapping $mapping, UploadedFile $file, ?string $dir, string $name): void
    {
        $fs = $this->getFilesystem($mapping);
        $path = !empty($dir) ? $dir.'/'.$name : $name;

        $stream = fopen($file->getRealPath(), 'r');
        $fs->putStream($path, $stream, [
            'mimetype' => $file->getMimeType(),
        ]);
    }

}