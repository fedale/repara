<?php

namespace App\Controller\Admin\Asset;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Entity\Asset\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AssetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Asset::class;
    }

    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //         ->overrideTemplates([
    //             'crud/edit' => 'admin/pages/layout_left_sidebar.html.twig'
	//     ]);
    // }
   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('model'),
            //AssociationField::new('entity.model'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->leftJoin("entity.model", "m");
        $response->leftJoin("m.brand", "b");

        return $response;
    }
   
}
