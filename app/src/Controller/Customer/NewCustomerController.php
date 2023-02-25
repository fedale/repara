<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
use Fedale\Gridview\Column\ColumnInterface;
use Fedale\Gridview\Component\Pagination;
use Fedale\Gridview\DataProvider\EntityDataProvider;
use Fedale\Gridview\GridView;
use Fedale\Gridview\GridviewBuilder;
use Fedale\Gridview\GridviewBuilderFactory;
use Fedale\Gridview\Source\Entity as SourceEntity;
use App\Service\ProxyFilter;
use App\Type\CustomerGridType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Fedale\Gridview\Component\PaginationInterface;
use Fedale\Gridview\Component\Sort;
use Fedale\Gridview\Component\SortInterface;
use Fedale\Gridview\DataProvider\DataProviderInterface;
use Fedale\Gridview\Form\FilterModelType;
use Fedale\Gridview\GridviewBuilderInterface;
use Fedale\Gridview\Service\FilterModel;

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
        // SortInterface $sort, 
        // PaginationInterface $pagination,
        Request $request): Response
    {

        /*        
        $pagination->setDefaultPageSize(10);

        $sort->setAttributes([
            'id' => [
                'asc' => ['c.id' => Sort::ASC],
                'desc' => ['c.id' => Sort::DESC],
                'default' => Sort::DESC,
            ],
            'code' => [
                'asc' => ['c.code' => Sort::ASC],
                'desc' => ['c.code' => Sort::DESC],
                'default' => Sort::DESC,
            ],
            'E-Mail' => [
                'asc' => ['c.email' => Sort::ASC],
                'desc' => ['c.email' => Sort::DESC],
                'default' => Sort::DESC,
                'label' => 'IDDDD',
            ],
            'Fullname' => [
                'asc' => ['p.firstname' => Sort::ASC, 'p.lastname' => Sort::ASC],
                'desc' => ['p.firstname' => Sort::DESC, 'p.lastname' => Sort::DESC],
                'default' => ['p.firstname' => Sort::ASC, 'p.lastname' => Sort::ASC],
                'label' => 'mylabel',
            ],
            '#' => [
                'asc' => ['c.email' => Sort::ASC],
                'desc' => ['c.email' => Sort::DESC],
                'default' => Sort::DESC,
                'label' => 'IDDDD',
            ],

        ]);
        */

        /**
         *
         */
        $columns = [
            // [
            //     'type' => 'serial'
            // ],
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
                'label' => 'Label 2'
            ],
            [
            //    'attribute' => 'email',
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
                ]
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
      //  $dataProvider->setSort($sort);
      //  $dataProvider->setPagination($pagination);

        // Order matters! Try to switch setColumns() / setFilterModel()
        $gridview = $this->createGridviewBuilder()
            ->setDataProvider($dataProvider)
            //->setFilterModel(new FilterModel()) // bypass for the moment
            ->setColumns($columns)
            ->renderGridview();
        ;

         // $form = $this->createFormBuilder([], ['method' => 'GET']);
         $form = $this->createForm(FilterModelType::class, [], ['method' => 'GET']);
         $form->handleRequest($request);
         
         if ($form->isSubmitted() ) {
             // dump($form->getData());
         }

        // return $gridview->renderGrid('new-customer/index.html.twig', ['pagination' => $pagination, 'form' => $form->createView()]);
        return $gridview->renderGrid('@Gridview/gridview/index.html.twig', ['form' => $form->createView()]);
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
