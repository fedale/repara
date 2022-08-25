<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;

class AbstractCrudController extends \EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return self::class;
    }

    public function deactivate(BatchActionDto $batchActionDto)
    {
        $className = $batchActionDto->getEntityFqcn();
        $entityManager = $this->container->get('doctrine')->getManagerForClass($className);
        foreach ($batchActionDto->getEntityIds() as $id) {
            
            $item = $entityManager->find($className, $id);
            dump($item);
            $item->setActive(false);
        }
        $entityManager->flush();

        return $this->redirect($batchActionDto->getReferrerUrl());
    }

    public function activate(BatchActionDto $batchActionDto)
    {
        $className = $batchActionDto->getEntityFqcn();
        $entityManager = $this->container->get('doctrine')->getManagerForClass($className);
        foreach ($batchActionDto->getEntityIds() as $id) {
            $item = $entityManager->find($className, $id);
            $item->setActive(true);
        }

        $entityManager->flush();

        return $this->redirect($batchActionDto->getReferrerUrl());
    }
   
}
