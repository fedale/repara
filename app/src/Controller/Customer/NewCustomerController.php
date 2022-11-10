<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
use App\Grid\GridView;
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

    public function __construct(EntityManagerInterface $entityManager, GridView $gridView) {
        $this->gridView = $gridView;
    }

    #[Route('/grid', name: 'new_app_grid', methods: ['GET'])]
    public function grid(EntityManagerInterface $entityManager): Response
    {
        $columns = [
            [
                'property' => 'id',
                'type' => 'serial' // column type
            ],
            [
                'property' => 'code',
                'type' => 'serial' // column type
            ],
            [
                'property' => 'username',
                'type' => 'serial' // column type
            ],
            [
                'property' => 'email',
                'type' => 'serial' // column type
            ],
            [
                'property' => 'username',
                'type' => 'serial',
                'value' => 'my custom value'
            ],
            // [
            //     'property' => 'actions',
            //     'type' => 'serial' // column type
            // ]
        ];

        $this->gridView->init(Customer::class, $columns);

        return $this->gridView->renderGrid('new-customer/index.html.twig');
    }

    #[Route('/', name: 'app_customer_customer_index', methods: ['GET', 'POST'])]
    public function index(
        EntityManagerInterface $entityManager, 
        Entity $entity, 
        Grid $grid,
        GridFactory $gridFactory,
        GridManager $gridManager,
        Request $request
    ): Response
    {
        $entity->setup(['entity' => 'App\Entity\Customer\Customer']);

        // Creates the builder
        $gridBuilder =  $gridFactory->createBuilder('grid', $entity, [
            'persistence'  => true,
            'route'        => 'app_customer_customer_index',
            'filterable'   => true,
            'sortable'     => true,
            'max_per_page' => 10,
        ]);
        // dd($entity, $gridBuilder);

        // Creates columns
        $grid = $gridBuilder
            ->add('id', 'number', [
                'title'   => '#',
                'primary' => 'true',
            ])
            ->add('code', 'text')
            ->add('username', 'text')
            ->add('email', 'text')
            ->add('active', 'boolean')
            // ->add('created_at', 'datetime', [
            //     'field' => 'createdAt',
            // ])
            // ->add('status', 'text')
            ->getGrid();

        // Handles filters, sorts, exports, ...
        $grid->handleRequest($request);

        // Renders the grid
        return $this->render('customer/apy_index.html.twig', ['grid' => $grid]);



        $source = $entity->setSource(Customer::class);

         // Creates the grid from the type: does not work yet
        $grid = $this->createGrid($gridFactory, new CustomerGridType($entity));

        // Method using GridManager. It works!
        // $grid = $gridManager->createGrid();
        // $grid->setSource($source);
        // return $grid->getGridResponse('customer/apy_index.html.twig');
        // dd($grid);

        // Creates the builder does not work yet
        // $gridBuilder = $gridFactory->createBuilder (
        //     'grid',
        //     $source, 
        //     [
        //         'persistence'  => true,
        //         'route'        => 'product_list',
        //         'filterable'   => false,
        //         'sortable'     => false,
        //         'max_per_page' => 20,
        //     ]
        // );
        // // Creates columns
        // $grid = $gridBuilder
        //     ->add('id', 'number', [
        //         'title'   => '#',
        //         'primary' => 'true',
        //     ])
        //     ->add('name', 'text')
        //     ->add('created_at', 'datetime', [
        //         'field' => 'createdAt',
        //     ])
        //     ->add('status', 'text')
        //     ->getGrid();

        dd($gridBuilder);

        $grid->setSource($source);
        $grid->hideColumns(['username', 'email']);
        $customers = $entityManager
            ->getRepository(Customer::class)
            ->findAll();
        
        return $grid->getGridResponse('customer/apy_index.html.twig');

            // $propertyAccessor = PropertyAccess::createPropertyAccessor();
            // foreach ($customers as $customer) {
            //     dump($customer);
            //     dump($entityManager->getClassMetadata(Customer::class));
            // }
            // die();
        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
            'title' => 'My title',
            //'columns' => $entityManager->getClassMetadata(Customer::class)
             'columns' => ['Id', 'Code', 'Username', 'Email', 'Password', 'UnconfirmedEmail', 'RegistrationIp', 'Active', 'ConfirmedAt', 'LastLoginAt', 'BlockedAt', 'CreatedAt', 'UpdatedAt', 'actions']
        ]);
    }

    /**
     * @return GridBuilder
     */
    public function createGridBuilder(Source $source = null, array $options = [])
    {
        return $this->container->get('apy_grid.factory')->createBuilder('grid', $source, $options);
    }

     /**
     * @return Grid
     */
    public function createGrid(GridFactory $gridFactory, $type, Source $source = null, array $options = [])
    {
        return $gridFactory->create($type, $source, $options);
    }
}