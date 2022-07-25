<?php

namespace App\Controller\Admin\Project;

use App\DBAL\Types\ProjectTaskEnumType;
use App\Entity\Project\Task\ProjectTask;
use App\Workflow\ProjectTaskWorkflow;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProjectTaskCrudController extends AbstractCrudController
{
    private projectTaskWorkflow $projectTaskWorkflow;

    private EntityManagerInterface $em;

    public function __construct(ProjectTaskWorkflow $projectTaskWorkflow, EntityManagerInterface $em)
    {
        $this->projectTaskWorkflow = $projectTaskWorkflow;
        $this->em = $em;
    }
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
                ->setChoices(ProjectTaskEnumType::getChoices())
                ->renderAsNativeWidget()
                ->setRequired(true)
            ,
         //   TextField::new('priority'),
            AssociationField::new('customer')
                ->renderAsNativeWidget()
            ,
            AssociationField::new('customerLocationPlaceAsset'),
            // AssociationField::new('assignedUsers'),

        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $validateAction = Action::new('validate', 'Valida', 'fa fa-check')
            ->linkToCrudAction('validate')
            ->displayIf(fn (ProjectTask $projectTask) => $this->projectTaskWorkflow->canValidate($projectTask))
            ->addCssClass('btn-sm btn-success')
        ;

        $actions
            ->add(Crud::PAGE_INDEX, $validateAction);

        return $actions;
    }

    public function validate (AdminContext $context, AdminUrlGenerator $adminUrlGenerator): Response
    {
        $projectTask = $context->getEntity()->getInstance();
        if (!$projectTask instanceof ProjectTask) {
            throw new \RuntimeException('Invalid project Task');
        }

        /** @var Session */
        $session = $context->getRequest()->getSession();
        $adminUrlGenerator->setController(self::class)->setAction('index')->removeReferrer()->setEntityId(null);

        try {
            $this->projectTaskWorkflow->validate($projectTask);
            $this->em->flush();
            $session->getFlashBag()->add('success', "Project Task {$projectTask->getName()} validated");
        } catch (\Exception $e) {
            $session->getFlashBag()->add('error', $e->getMessage());
        }

        return $this->redirect($adminUrlGenerator->generateUrl());

    }
}
