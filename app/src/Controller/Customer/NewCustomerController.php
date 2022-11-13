<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
use App\Grid\GridView;
use App\Grid\GridviewBuilder;
use App\Grid\GridviewBuilderFactory;
use App\Grid\Source\Entity as SourceEntity;
use App\Type\CustomerGridType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\Persistence\ManagerRegistry;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Source\Source;
use APY\DataGridBundle\Grid\GridFactory;
use APY\DataGridBundle\Grid\GridManager;
use Doctrine\ORM\EntityManager;

#[Route('/new-customer')]
class NewCustomerController extends AbstractController
{

    private $gridView;

    private GridviewBuilderFactory $gridviewBuilderFactory;

    public function __construct(
        GridviewBuilderFactory $gridviewBuilderFactory
    ) {
        $this->gridviewBuilderFactory = $gridviewBuilderFactory;
    }

    #[Route('/grid', name: 'new_app_grid', methods: ['GET'])]
    public function grid(EntityManagerInterface $entityManager): Response
    {
        $columns = [
            [
                'property' => 'id',
                'type' => 'serial' // column type
            ],
            // [
            //     'property' => 'code',
            //     'type' => 'serial' // column type
            // ],
            // [
            //     'property' => 'username',
            //     'type' => 'serial' // column type
            // ],
            // [
            //     'property' => 'email',
            //     'type' => 'serial' // column type
            // ],
            // [
            //     'property' => 'username',
            //     'type' => 'serial',
            //     'value' => 'my custom value'
            // ],
        ];

        $source = $entityManager
            ->getRepository(Customer::class)
            ->findAll();

        return $this->createGridviewBuilder()
            ->setColumns($columns)
            ->setSource($source)
            ->renderGridview('new-customer/index.html.twig');
        ;
    }
    
    public function createGridviewBuilder(): GridviewBuilder
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}