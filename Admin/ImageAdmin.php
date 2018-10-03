<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MKebza\Content\Admin;

use MKebza\Content\Entity\Image;
use MKebza\Content\ORM\EntityImage;
use MKebza\SonataExt\Admin\AbstractAdmin;
use MKebza\SonataExt\Utils\FilesizeFormatter;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Model\Metadata;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'created',
    ];

    protected $baseRoutePattern = 'image';
    protected $baseRouteName = 'image';

    public function configure()
    {
        parent::configure();
        $this->classnameLabel = 'Image';

        $this->setTemplate('outer_list_rows_mosaic', '@MKebzaContent/image/outer_list_rows_mosaic.html.twig');
        $this->setTemplate('edit', '@MKebzaContent/image/edit.html.twig');
    }

    /**
     * @param Image $object
     *
     * @return Metadata
     */
    public function getObjectMetadata($object)
    {
        // Create image URL
        $imageUrl = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('vich_uploader.templating.helper.uploader_helper')
            ->asset($object, 'image');
        $imageUrl = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('liip_imagine.cache.manager')
            ->getBrowserPath($imageUrl, 'admin_preview_big');

        $description = sprintf(
            "Size: %sx%spx\nFilesize: %s",
            $object->getWidth(),
            $object->getHeight(),
            $object->getSize()
        );

        // if for singe image behavior
        $primary = false;
        if (
                null !== $object->getReference() &&
                in_array(EntityImage::class, (new \ReflectionClass($object->getReference()))->getTraitNames(), true) &&
                $object->getReference()->getImage() === $object
        ) {
            $primary = true;
        }

        return new Metadata(
            (string) $object,
            [
                'Image.field.dimensions' => sprintf('%sx%s', $object->getWidth(), $object->getHeight()),
                'Image.field.size' => FilesizeFormatter::format($object->getSize()),
                'Image.field.mime' => $object->getMime(),
            ],
            $imageUrl,
            '',
            [
                'main' => $primary,
            ]
        );
    }

    public function prePersist($object)
    {
        if (0 === $object->getReference()->getImages()->count()) {
            $object->getReference()->setImage($object);
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);

        $collection->add('set_main', $this->getRouterIdParameter().'/setMain');
    }

    protected function configureFormFields(FormMapper $form)
    {
        parent::configureFormFields($form);

        $form
            ->with(null);

        if ($this->isCreating()) {
            $form->add('image', VichImageType::class, ['attr' => ['class' => 'image-multi-tab-input-file']]);
        }

        $form
            ->add('name', null, ['attr' => ['class' => 'image-multi-tab-input-name']])
            ->ifEnd();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('_action', null, ['actions' => [
                'edit' => [],
                'delete' => []
            ]])
        ;
    }

//    public function getListModes()
//    {
//        return ["mosaic" => ["class" => "fa fa-th-large fa-fw"]];
//    }
}
