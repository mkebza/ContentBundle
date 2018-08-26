<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\EventListener\Image;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use MKebza\Content\ORM\EntityImageMany;

class ImageMultiMapRelationListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        $metadata = $event->getClassMetadata();

        if (!in_array(EntityImageMany::class, $metadata->getReflectionClass()->getTraitNames(), true)) {
            return;
        }

        $metadata->mapOneToMany([
            'fieldName' => 'images',
            'targetEntity' => ($metadata->getReflectionClass()->getName())::getImagesEntityFQN(),
            'mappedBy' => 'reference',
        ]);
    }
}
