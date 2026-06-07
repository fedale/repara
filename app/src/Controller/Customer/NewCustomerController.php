<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
use Fedale\GridviewBundle\Contract\ColumnInterface;
use Fedale\GridviewBundle\Contract\DataProviderInterface;
use Fedale\GridviewBundle\Contract\GridviewBuilderInterface;
use Fedale\GridviewBundle\Contract\PaginationInterface;
use Fedale\GridviewBundle\Contract\SortInterface;
use Fedale\GridviewBundle\DataProvider\EntityDataProvider;
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;
use Fedale\GridviewBundle\Pagination\Pagination;
use Fedale\GridviewBundle\Sort\Sort;
use App\Service\ProxyFilter;
use App\Type\CustomerGridType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

#[Route('/new-customer')]
class NewCustomerController extends AbstractController
{
    private $gridView;

    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
    ) {
    }

    #[Route('/grid', name: 'new_app_grid', methods: ['GET'])]
    public function grid(
        EntityManagerInterface $entityManager, 
        DataProviderInterface $dataProvider, 
        SortInterface $sort, 
        PaginationInterface $pagination,
        Request $request): Response
    {

        
        $pagination->setDefaultPageSize(10);

        $sortAttributes = [
            'id' => [
                'asc'     => ['c.id'],
                'desc'    => ['c.id'],
                'default' => 'desc',
            ],
            'code' => [
                'asc'     => ['c.code'],
                'desc'    => ['c.code'],
                'default' => 'desc',
            ],
            'E-Mail' => [
                'asc'     => ['c.email'],
                'desc'    => ['c.email'],
                'default' => 'desc',
                'label'   => 'IDDDD',
            ],
            'Fullname' => [
                'asc'     => ['p.firstname', 'p.lastname'],
                'desc'    => ['p.firstname', 'p.lastname'],
                'default' => 'asc',
                'label'   => 'mylabel',
            ],
            '#' => [
                'asc'     => ['c.email'],
                'desc'    => ['c.email'],
                'default' => 'desc',
                'label'   => 'IDDDD',
            ],
        ];

        /**
         *
         */
        $columns = [
            // [//     'type' => 'serial'// ],
            'id',
            'code:raw:code',
            [
                'value' => function(array $data, string $key, ColumnInterface $column) {
                    return rand(0, 10) > 5 ? 
                        '<strong>' . $data['profile']['fullname'] . '</strong>'
                        : 
                        '*****';
                },
                'twigFilter' => 'raw',
                'visible' => true,
                'label' => 'Label 2',
                'attribute' => 'profile_fullname',
            ],
            [
               'attribute' => 'email',
               'label' => 'email',
               'value' => function (array $data, string $key, ColumnInterface $column) {
                    return '<strong>' . $data['email'] . '</strong>';
                },
                'twigFilter' => 'raw',
                'filter' => [
                    'type' => 'text',
                    'visibile' => true
                ]
            ],
        //    'profile.fullname:raw:fullname',
            [
                'attribute' => 'locations',
                'label' => 'locations',
                'value' => function (array $data, string $key, ColumnInterface $column) {
                    $arr = [];
                    foreach ($data['locations'] as $location) {
                        $link = sprintf('<a href="/location/%s">%s</a>', $location['id'], $location['zipcode']);
                        \array_push($arr, $link);
                    }
                    return $arr;
                },
                'twigFilter' => "join(', ', ' and ')|raw",
                'filter' => [
                    'type' => 'text',
                ],

            ],
            // [
            //     'attribute' => 'createdAt'
            // ]
                
        ];

        $queryBuilder = $entityManager
            ->getRepository(\App\Entity\Customer\Customer::class)
            ->createQueryBuilder('c')
            ->select('c ', 'p', 'l')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
            ;

        $dataProvider->setQueryBuilder($queryBuilder);
        $dataProvider->setSort($sort);
      //  $dataProvider->setPagination($pagination);

    //    $formFactory = \Symfony\Component\Form\Forms::createFormFactory();
        //  $form = $formFactory->create(FilterModelType::class, [], ['method' => 'GET']);// dd($formFactory);
        
   //     $form = $this->createForm(FilterModelType::class, [], ['method' => 'GET']);

        // dd($form);
        // Order matters! Try to switch setColumns() / setFilterModel()
        $gridview = $this->createGridviewBuilder()
            ->setDataProvider($dataProvider)
            ->setFilterModelType(FilterModelType::class) 
            ->setColumns($columns)
            ->setAttributes([
                'class' => 'table table-dark',
                'row' => [
                    'class' => 'row-class'
                ],
                'header' => [
                    'class' => 'row-header'
                ],
                'container' => [
                    'class' => 'row-container',
                    'data-type' => 'my-custom-type'
                ]
            ])
            ->renderGridview();
        ;


        return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', ['pagination' => $pagination]); //, 'form' => $form->createView()]);
    }

    #[Route('/grid2', name: 'new_app_grid2', methods: ['GET'])]
    public function grid2(EntityManagerInterface $entityManager, EntityDataProvider $dataProvider, Sort $sort, Pagination $pagination): Response
    {

        $pagination->setDefaultPageSize(10);

        /**
         *
         */
        $columns = [
            'id',
            'code:raw:codice',
            'username',
            'email'
        ];

        $queryBuilder = $entityManager
            ->getRepository(\App\Entity\Customer\Customer::class)
            ->createQueryBuilder('c')
            ;

        $dataProvider->setQueryBuilder($queryBuilder);
        $dataProvider->setSort($sort);
        $dataProvider->setPagination($pagination);

        $gridview = $this->createGridviewBuilder()
            ->setDataProvider($dataProvider)
            ->setColumns($columns)
            ->renderGridview();
        ;

        return $gridview->renderGrid('new-customer/index.html.twig', ['pagination' => $pagination]);
    }
    
    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}
