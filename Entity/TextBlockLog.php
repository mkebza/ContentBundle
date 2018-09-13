<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Entity;

use Doctrine\ORM\Mapping as ORM;
use MKebza\SonataExt\Entity\LogReference;

/**
 * Class TextBlockLog.
 *
 * @ORM\Entity()
 */
class TextBlockLog extends LogReference
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Content\TextBlock", inversedBy="log")
     */
    protected $reference;

    public static function getDiscriminatorEntryName(): string
    {
        return 'text_block';
    }
}
