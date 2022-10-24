<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
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

#[Route('/customer')]
class CustomerController extends AbstractController
{

    #[Route('/', name: 'app_customer_customer_index', methods: ['GET', 'POST'])]
    public function index(
        EntityManagerInterface $entityManager, 
        Entity $entity, 
        Grid $grid,
        GridFactory $gridFactory,
        GridManager $gridManager
    ): Response
    {
        // Creates the builder
        $gridBuilder = $this->createGridBuilder(new Entity(Customer::class), [
            'persistence'  => true,
            'route'        => 'product_list',
            'filterable'   => false,
            'sortable'     => false,
            'max_per_page' => 20,
        ]);

        // Creates columns
        $grid = $gridBuilder
            ->add('id', 'number', [
                'title'   => '#',
                'primary' => 'true',
            ])
            ->add('name', 'text')
            ->add('created_at', 'datetime', [
                'field' => 'createdAt',
            ])
            ->add('status', 'text')
            ->getGrid();

        // Handles filters, sorts, exports, ...
        $grid->handleRequest($request);

        // Renders the grid
        return $this->render('MyProjectBundle:Product:list', ['grid' => $grid]);



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

    #[Route('/new', name: 'app_customer_customer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $customer = new CustomerCreateModel();
        $form = $this->createForm(CustomerRegistrationType::class);
        $form->handleRequest($request);
        $customerType = $entityManager->getRepository(CustomerCustomerType::class)->findOneById(11);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CustomerCreateModel $customerModel */
            $customerModel = $form->getData();

            $customer = new Customer();
            $customerProfile = new CustomerProfile();
            
            $customer->setCode($customerModel->code);
            $customer->setUsername($customerModel->username);
            $customer->setEmail($customerModel->email);
            $customer->setPassword($customerModel->password);
            $customer->setType($customerType);//$customerModel->type);
            $entityManager->persist($customer);

            $customerProfile->setCustomer($customer);
            $customerProfile->setFirstname($customerModel->firstname);
            $customerProfile->setLastname($customerModel->lastname);
            $entityManager->persist($customerProfile);

            $entityManager->flush();

            return $this->redirectToRoute('app_customer_customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customer/new.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_customer_customer_show', methods: ['GET'])]
    public function show(Customer $customer): Response
    {
        return $this->render('customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_customer_customer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Customer $customer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_customer_customer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_customer_customer_delete', methods: ['POST'])]
    public function delete(Request $request, Customer $customer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_customer_customer_index', [], Response::HTTP_SEE_OTHER);
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
