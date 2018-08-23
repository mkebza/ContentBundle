<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Twig\Runtime;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use MKebza\Content\ORM\ImageInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageRuntime implements RuntimeExtensionInterface
{
    /**
     * @var UploaderHelper
     */
    private $helper;

    /**
     * @var CacheManager
     */
    private $imagineCache;

    /**
     * ImageRuntime constructor.
     *
     * @param UploaderHelper $helper
     * @param CacheManager   $imagineCache
     */
    public function __construct(UploaderHelper $helper, CacheManager $imagineCache)
    {
        $this->helper = $helper;
        $this->imagineCache = $imagineCache;
    }

    /**
     * Gets the public path for the file associated with the uploadable object.
     *
     * @param Image $obj The object
     *
     * @return null|string
     */
    public function imageAsset(ImageInterface $obj): ?string
    {
        return $this->helper->asset($obj, 'image', null);
    }

    /**
     * Gets the public path for the file associated with the uploadable object.
     *
     * @param Image $obj The object
     *
     * @return null|string
     */
    public function imageThumb(?ImageInterface $obj, string $filter, string $default = null): ?string
    {
        if (null === $obj) {
            return $default;
        }

        $path = $this->helper->asset($obj, 'image', null);

        return $this->imagineCache->resolve($path, $filter);
    }
}
