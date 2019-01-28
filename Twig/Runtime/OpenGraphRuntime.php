<?php

declare(strict_types=1);


namespace MKebza\Content\Twig\Runtime;


use Twig\Extension\RuntimeExtensionInterface;

class OpenGraphRuntime implements RuntimeExtensionInterface
{

    protected $env;

    public function initRuntime(\Twig_Environment $env)
    {
        parent::initRuntime($env);
        $this->env = $env;

        dd("test");
    }

    public function openGraph(\Twig_Environment $env, array $options): string
    {
        $escape = $env->getFilter('escape')->getCallable();

        $output = '';
        foreach ($options as $key => $value) {
            $output .= sprintf(
                '<meta property="og:%s" content="%s" />',
                $escape($env, $key, 'html'),
                $escape($env, $value, 'html')
            );
        }

        return $output;
    }

}