<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
use App\Grid\Column\ColumnInterface;
use App\Grid\DataProvider\EntityDataProvider;
use App\Grid\GridView;
use App\Grid\GridviewBuilder;
use App\Grid\GridviewBuilderFactory;
use App\Grid\Source\Entity as SourceEntity;
use App\Service\ProxyFilter;
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
use App\Grid\Component\Sort;

#[Route('/new-customer')]
class NewCustomerController extends AbstractController
{
    private $gridView;

    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
    ) {
    }

    #[Route('/grid', name: 'new_app_grid', methods: ['GET'])]
    public function grid(EntityManagerInterface $entityManager, EntityDataProvider $dataProvider, Sort $sort): Response
    {
        /*
        $sort->setAttributes([
            'attributes' => [
                'id' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Name',
                ],
            ],
        ]);*/

        $sort->setDefaultOrder([
            'c.id' => Sort::DESC
        ]);
        
        
        $sort->setAttributes([
            'c.id' => [
                'asc' => ['c.id' => Sort::ASC],
                'desc' => ['c.id' => Sort::DESC],
                'default' => Sort::DESC,
                'label' => 'IDDDD',
            ]
        ]);
        

        /**
         *
         */
        $columns = [
            // [
            //    'type' => 'serial', // array with SerialColumn
            // //   'visible' => rand(0, 10) > 5 ? true : false
            // ],
            'id',
            'code:raw:codice',
            [
                'value' => function(array $data, string $key, ColumnInterface $column) {
                    return rand(0, 10) > 5 ? 
                        '<strong>' . $data['profile']['fullname'] . '</strong>'
                        : 
                        null;
                },
                'twigFilter' => 'raw',
                'visible' => false
            ],
            [
            //    'attribute' => 'email',
               'label' => 'E-Mail',
               'value' => function (array $data, string $key, ColumnInterface $column) {
                    return '<strong>' . $data['email'] . '</strong>';
                },
                'twigFilter' => 'raw'
            ],
            
            'profile.firstname:raw:codice',
            [
                'value' => function (array $data, string $key, ColumnInterface $column) {
                    $arr = [];
                    foreach ($data['locations'] as $location) {
                        $link = sprintf('<a href="/location/%s">%s</a>', $location['id'], $location['zipcode']);
                        \array_push($arr, $link);
                    }
                    return $arr;
                },
                'twigFilter' => "join(', ', ' and ')|raw"
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

        $gridview = $this->createGridviewBuilder()
            ->setDataProvider($dataProvider)
            ->setColumns($columns)
            ->renderGridview();
        ;

        return $gridview->renderGrid('new-customer/index.html.twig');
    }
    
    public function createGridviewBuilder(): GridviewBuilder
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}
