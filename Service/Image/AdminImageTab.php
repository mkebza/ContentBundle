<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\Image;

use MKebza\SonataExt\Form\Type\TemplateType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

trait AdminImageTab
{
    public function tabImages(FormMapper $mapper)
    {
        $subject = $this->getSubject();

        $mapper
            ->tab('Obrázky')
                ->with(null)
                    ->add('_newImage', FileType::class, ['mapped' => false])
                    ->add('_images', TemplateType::class, [
                        'template' => '@MKebzaContent/image/image_tab.html.twig',
                        'vars' => [
                            'images' => $subject->getImages(),
                            'main' => $subject->getImage(),
                            //                            'setMainRoute' => function (Image $image) {
                            //                                return $this->generateUrl('set_main_image', [
                            //                                    'id' => $this->getSubject()->getId(), 'image' => $image->getId(), ]);
                            //                            },
                        ],
                    ])
                ->end()
            ->end();
    }
}
