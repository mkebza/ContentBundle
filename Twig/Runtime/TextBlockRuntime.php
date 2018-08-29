<?php

declare(strict_types=1);


namespace MKebza\Content\Twig\Runtime;


use MKebza\Content\Entity\TextBlock;
use MKebza\Content\Repository\TextBlockRepository;
use Twig\Extension\RuntimeExtensionInterface;

class TextBlockRuntime implements RuntimeExtensionInterface
{

    /**
     * @var TextBlockRepository
     */
    private $repository;

    /**
     * TextBlockRuntime constructor.
     * @param TextBlockRepository $repository
     */
    public function __construct(TextBlockRepository $repository)
    {
        $this->repository = $repository;
    }


    public function get(string $key): ?TextBlock
    {
        return $this->repository->getByKey($key);
    }
}