<?php

namespace App\Controller\Admin\Project;

use App\Entity\Project\TaskTemplate\ProjectTaskTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectTaskTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjectTaskTemplate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextareaField::new('description'),
            BooleanField::new('active')
        ];
    }
}
