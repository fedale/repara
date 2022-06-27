<?php

namespace App\Controller\Admin\Customer;

use App\Entity\Customer\CustomerPlaceAssetAttachment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CustomerPlaceAssetAttachmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CustomerPlaceAssetAttachment::class;
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
