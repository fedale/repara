<?php

namespace App\Controller\Admin\Project;

use App\Entity\Project\ProjectTask;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectTaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjectTask::class;
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
