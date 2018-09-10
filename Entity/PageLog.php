<?php

declare(strict_types=1);


namespace MKebza\Content\Entity;


use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\Entity\LogReference;

/**
 * Class PageLog
 * @package MKebza\Content\Entity
 * @ORM\Entity()
 */
class PageLog extends LogReference
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Content\Page", inversedBy="log")
     */
    protected $reference;

    public static function getDiscriminatorEntryName(): string
    {
        return 'page';
    }
}