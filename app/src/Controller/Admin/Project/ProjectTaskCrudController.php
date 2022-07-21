<?php

namespace App\Controller\Admin\Project;

use App\Entity\Project\Task\ProjectTask;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectTaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjectTask::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            AssociationField::new('type')
                ->renderAsNativeWidget()
            ,
            ChoiceField::new('status')
                ->setChoices([
                    'Richiesto' => 'requested',
                    'Rifiutato' => 'rejected',
                    'Approvato' => 'approved',
                    'In lavorazione' => 'current',
                    'Chiuso/Abortito' => 'dead',
                    'Completato' => 'completed',
                    'In attesa' => 'on_hold',
                    'Firmato/Completato' => 'signed' 
                ])
                ->renderAsNativeWidget()
            ,
         //   TextField::new('priority'),
            AssociationField::new('customer')
                ->renderAsNativeWidget()
            ,
            AssociationField::new('customerLocationPlaceAsset'),
            // AssociationField::new('assignedUsers'),

        ];
    }
}
