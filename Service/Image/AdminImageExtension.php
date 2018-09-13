<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Service\Image;

use App\Entity\Content\Image;
use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AdminImageExtension extends AbstractAdminExtension
{
    /**
     * @param AdminImageInterface|AdminInterface $admin
     * @param $object
     */
    public function preUpdate(AdminInterface $admin, $object)
    {
        $this->handleImageUpload($admin, $object, $admin->getImageFieldsMap());
    }

    /**
     * @param AdminImageInterface|AdminInterface $admin
     * @param $object
     */
    public function prePersist(AdminInterface $admin, $object)
    {
        $this->handleImageUpload($admin, $object, $admin->getImageFieldsMap());
    }

    protected function handleImageUpload(AdminInterface $admin, $object, $fields = [])
    {
        foreach ($fields as $formField => $entityField) {
            if (!$admin->getForm()->has($formField)) {
                continue;
            }

            $uploadedFile = $admin->getForm()->get($formField)->getData();
            if ($admin->getForm()->isValid() && $uploadedFile && $uploadedFile->isValid()) {
                $image = new Image();
                $image->setImage($uploadedFile);

                $admin->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->persist($image);

                PropertyAccess::createPropertyAccessor()->setValue($object, $entityField, $image);
            }
        }
    }
}
