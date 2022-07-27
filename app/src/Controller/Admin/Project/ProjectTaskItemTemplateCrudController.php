<?php

namespace App\Controller\Admin\Project;

use App\Entity\Project\TaskTemplate\ProjectTaskItemTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectTaskItemTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjectTaskItemTemplate::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('taskTemplate'),
            AssociationField::new('taskType'),
        ];
    }
}
