<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\VichUploader;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class ImageDirectoryNamer implements DirectoryNamerInterface
{
    private $cache = [];

    public function directoryName($object, PropertyMapping $mapping): string
    {
        $className = get_class($object);

        if (!isset($this->cache[$className])) {
            $shortName = (new \ReflectionClass($object))->getShortName();
            if ('Image' !== $shortName) {
                $shortName = str_replace('Image', '', $shortName);
            }

            $shortName = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $shortName));
            $this->cache[$className] = $shortName;
        }

        return $this->cache[$className];
    }
}
