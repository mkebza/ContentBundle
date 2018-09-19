<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\VichUploader;

use Cocur\Slugify\SlugifyInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class ImageNamer implements NamerInterface
{
    /**
     * @var SlugifyInterface
     */
    private $slugify;

    /**
     * ImageNamer constructor.
     *
     * @param SlugifyInterface $slugify
     */
    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        /** @var $file UploadedFile */
        $file = $mapping->getFile($object);
        $info = pathinfo($file->getClientOriginalName());

        $hash = md5_file($file->getRealPath());
        $hash = gmp_strval(gmp_init($hash, 16), 62); // Shorten hash using 62 as a base
        $hash = substr($hash, 0, 7); // And we dont need full length, dont expectict that much files, plus its combined with filename anyway

        $name = sprintf('%s_%s.%s',
            $hash,
            $this->slugify->slugify($info['filename']),
            strtolower($info['extension']));

        return $name;
    }
}
