<?php

namespace App\Controller\Admin\Asset;

use App\Entity\Asset\AssetAttachment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetAttachmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AssetAttachment::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
