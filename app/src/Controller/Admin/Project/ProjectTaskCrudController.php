<?php

namespace App\Controller\Admin\Project;

use App\DBAL\Types\ProjectTaskStateType;
use App\DBAL\Types\ProjectTaskPriorityType;
use App\Entity\Customer\CustomerLocationPlaceAsset;
use App\Entity\Project\Task\ProjectTask;
use App\Workflow\ProjectTaskWorkflow;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
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
        $customerLocationPlaceAssetRepository = $this->em->getRepository(CustomerLocationPlaceAsset::class);
        // dd($customerLocationPlaceAssetRepository->createQueryBuilder('entity'));
        return [
            TextField::new('name'),
            TextEditorField::new('description')
                ->onlyWhenUpdating()
            ,
            AssociationField::new('customer')
                ->renderAsNativeWidget()
            ,
            AssociationField::new('customerLocationPlaceAsset')
                ->renderAsNativeWidget()
                // ->setQueryBuilder(
                //     fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(CustomerLocationPlaceAsset::class)->findByCustomer()
                // )
            ,
            // yield AssociationField::new('...')->setQueryBuilder(
            //     fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(Foo::class)->findBySomeCriteria();
            // );
        
            AssociationField::new('type')
                ->renderAsNativeWidget()
            ,
            ChoiceField::new('priority')
                ->setChoices(ProjectTaskPriorityType::getChoices())
                ->renderAsNativeWidget()
                ->setRequired(true)
                ->addCssClass('col-md-7 col-xxl-6')
            ,
            ChoiceField::new('state')
                ->setChoices(ProjectTaskStateType::getChoices())
                ->renderAsNativeWidget()
                ->setRequired(true)
                ->addCssClass('col-md-7 col-xxl-6')
            ,
            AssociationField::new('projectTaskUserAssigneds')
                // ->setFormTypeOption('expanded', true)
            ,

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
