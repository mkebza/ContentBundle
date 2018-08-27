<?php

declare(strict_types=1);


namespace MKebza\Content\EventListener\Image;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\Mapping\MappingException;
use MKebza\Content\Entity\Image;
use MKebza\SonataExt\ORM\DiscriminatorMapEntryInterface;

class MapInheritanceListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        $metadata = $event->getClassMetadata();
        $classes = [];

        if (!$metadata->getReflectionClass()->isSubclassOf(Image::class)) {
            return;
        }

        $newMap = [];
        foreach ($metadata->discriminatorMap as $alias => $fqn) {
            $fqnReflection = (new \ReflectionClass($fqn));

            $newName = null;
            if (
                    $fqnReflection->implementsInterface(DiscriminatorMapEntryInterface::class) &&
                    !$fqnReflection->getMethod('getDiscriminatorEntryName')->isAbstract()
            ) {
                 $newName = $fqn::getDiscriminatorEntryName();
            } else {
                $shortName = $fqnReflection->getShortName();
                $newName = strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $shortName));
            }

            $newMap[$newName] = $fqn;
        }

        $metadata->discriminatorMap = $newMap;
    }
}