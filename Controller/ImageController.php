<?php

/*
 * Author: (c) Marek Kebza <marek@kebza.cz>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace MKebza\Content\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MKebza\SonataExt\Enum\AdminFlashMessage;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class ImageController extends CRUDController
{
    public function setMainAction($id, $childId, $childChildId, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        // Shift params for more deep admins
        if (null !== $childChildId) {
            $id = $childId;
            $childId = $childChildId;
        }

        $image = $em
            ->getRepository($this->getParameter('mkebza_content.entity.image'))
            ->find($childId);

        $entity = $em
            ->getRepository((new \ReflectionClass($image->getReference()))->getName())
            ->find($image->getReference()->getId());

        $entity->setImage($image);
        $em->persist($entity);
        $em->flush();

        $this->addFlash(
            AdminFlashMessage::SUCCESS,
            $translator->trans(
                'Image.action.setMain.flashSuccess',
                [
                    ':image' => $image->getName(),
                    ':entity' => (string) $entity,
                ],
                'admin'));

        return $this->redirect($this->admin->generateObjectUrl('list', $image));
    }

    protected function preList(Request $request)
    {
        $this->admin->setListMode('mosaic');

        parent::preList($request);
    }
}
