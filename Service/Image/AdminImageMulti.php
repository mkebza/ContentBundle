<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\Image;

use MKebza\Content\ORM\Imageable;
use MKebza\Content\ORM\ImageInterface;
use MKebza\SonataExt\Form\Type\TemplateType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

trait AdminImageMulti
{
    public function tabImages(FormMapper $mapper): void
    {
        $subject = $this->getSubject();

        $mapper
            ->tab('Image.action.imageMultiTab.title')
                ->with(null)
                    ->add('_multiNewImage', FileType::class, [
                        'mapped' => false,
                        'label' => 'Image.action.imageMultiTab.selectNewImage',
                        'required' => false,
                        'attr' => ['class' => 'image-multi-tab-input-file'],
                    ])
                    ->add('_multiNewImageName', TextType::class, [
                        'mapped' => false,
                        'label' => 'Image.action.imageMultiTab.name',
                        'required' => false,
                        'attr' => ['class' => 'image-multi-tab-input-name'],
                    ])

                    ->add('_images', TemplateType::class, [
                        'template' => '@MKebzaContent/image/image_tab.html.twig',
                        'vars' => [
                            'images' => $subject->getImages(),
                            'main' => $subject->getImage(),
                            'object' => $subject,
                            'enableSetMain' => true,
                            //                            'setMainRoute' => function (Image $image) {
                            //                                return $this->generateUrl('set_main_image', [
                            //                                    'id' => $this->getSubject()->getId(), 'image' => $image->getId(), ]);
                            //                            },
                        ],
                    ])
                ->end()
            ->end();
    }

    public function handleImageSave(object $entity, bool $autoSetPrimaryImage = true): void
    {
        if (!$this->getForm()->has('_multiNewImage')) {
            return;
        }

        $imageClass = $this->getConfigurationPool()->getContainer()->getParameter('mkebza_content.entity.image');

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $this->getForm()->get('_multiNewImage')->getData();
        if ($this->getForm()->isValid() && $uploadedFile && $uploadedFile->isValid()) {
            /** @var ImageInterface $image */
            $image = new $imageClass();
            $image->setImage($uploadedFile);

            $name = trim($this->getForm()->get('_multiNewImageName')->getData());
            if (!empty($name)) {
                $image->setName($name);
            }

            if ($autoSetPrimaryImage && !in_array(Imageable::class, (new \ReflectionClass($entity))->getTraitNames(), true)) {
                throw new \LogicException(sprintf(
                    "You have requested auto set primary image on %s entity, but your entity doesn't implement have trait %s which is required",
                    (new \ReflectionClass($entity))->getName(),
                    Imageable::class
                ));
            }

            if ($autoSetPrimaryImage && $entity->getImages()->isEmpty()) {
                $entity->setImage($image);
            }

            $entity->addImage($image);
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->persist($image);
        }
    }

    public function addImageRoutes(RouteCollection $collection): void
    {
        $collection->add('set_main_image', $this->getRouterIdParameter().'/set-main-image/{image}');
    }
}
