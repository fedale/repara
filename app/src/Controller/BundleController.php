<?php

namespace App\Controller;

use App\Service\CustomerSearchModel;
use Fedale\GridviewBundle\Contract\ColumnInterface;
use Fedale\GridviewBundle\Contract\GridviewBuilderInterface;
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;



#[Route('/bundle')]
class BundleController extends AbstractController
{
    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
        #[Autowire(service: 'fedale_gridview.gridview_builder')]
        private GridviewBuilderInterface $gridviewBuilder,
        //private CalendarBuilderFactory $calendarBuilderFactory,
        private CustomerSearchModel $customerSearchModel
    ) {

    }

    #[Route('/gridview', name: 'app_gridview', methods: ['GET'])]
    public function grid(
        Request $request
    ): Response {
        //      $pagination->setDefaultPageSize(10);
        $paginationAttributes = [
            'defaultPageSize' => 200
        ];

        $sortAttributes = [
            'id' => [
                'asc' => ['c.id'],
                'desc' => ['c.id'],
                'default' => 'desc',
            ],
            'code' => [
                'asc' => ['c.code'],
                'desc' => ['c.code'],
                'default' => 'desc',
            ],
            'E-Mail' => [
                'asc' => ['c.email'],
                'desc' => ['c.email'],
                'default' => 'desc',
                'label' => 'IDDDD',
            ],
            'Fullname' => [
                'asc' => ['p.firstname', 'p.lastname'],
                'desc' => ['p.firstname', 'p.lastname'],
                'default' => 'asc',
                'label' => 'mylabel',
            ],
            '#' => [
                'asc' => ['c.email'],
                'desc' => ['c.email'],
                'default' => 'desc',
                'label' => 'IDDDD',
            ],
        ];

        /**
         *
         */
        $columns = [
            ['type' => 'checkbox'],
            // [//     'type' => 'serial'// ],
            /*
        [
            'attribute' => 'id',
            'filter' => [
                'type' => 'text',
            ]
        ],*/
            'id',
            /*
            'code:raw:code',
            */
            [
                'attribute' => 'code',
                'filter' => [
                    'type' => 'text'
                ]
            ],
            [
                'attribute' => 'profile_fullname',
                'value' => function (array $data, string $key, ColumnInterface $column) {
                    return rand(0, 10) > 5 ?
                        '<strong>' . $data['profile']['fullname'] . '</strong>'
                        :
                        '*****';
                },
                'twigFilter' => 'raw',
                'visible' => true,
                'label' => 'Label 2',
                'filter' => [
                    'type' => 'text',
                ]
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
                ]
            ],

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
                'visible' => false
            ],
            [
                'attribute' => 't.name',
                'value' => function (array $data, string $key, ColumnInterface $column) {
                    return $data['username'];
                },
            ],
            [
                'type' => 'action'
            ]

        ];

        /*
        $queryBuilder = $entityManager
            ->getRepository(\App\Entity\Customer\Customer::class)
            ->createQueryBuilder('c')
            ->select('c ', 'p', 'l')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
            ;
        */
        $dataProvider = [
            // 'queryBuilder' => $queryBuilder,
            'models' => \App\Entity\Customer\Customer::class,
            'pagination' => $paginationAttributes,
            'sort' => $sortAttributes
        ];

        //$dataProvider->setQueryBuilder($queryBuilder);
        //$dataProvider->setPaginationAttributes($paginationAttributes);
        //   $dataProvider->setSort($sort);


        // Order matters! Try to switch setColumns() / setFilterModel()

        /* * @var Gridview $gridview */
        $gridview = $this->createGridviewBuilder()
            ->setSearchModel($this->customerSearchModel)
            ->setOptions([
                'layout' => [
                    'gridview' => '{toolbar} {header} {table} {footer}',
                    'toolbar'  => '{columnVisibility}',
                ],
            ])
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
            ->setDataProvider($dataProvider)
            ->setColumns($columns)
            ->renderGridview();


        return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', []);//, ['pagination' => $pagination]); //, 'form' => $form->createView()]);
    }

    /* * @return GridviewBuilder */
    public function createGridviewBuilder(): GridviewBuilder
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }

    /*
        #[Route('/gridview-1', name: 'app_gridview_1', methods: ['GET'])]
        public function grid1(
            Request $request
        ): Response
        {
            $columns = [
                'id',
                [
                    'attribute' => 'code',
                    'value' => function (array $data, string $key, ColumnInterface $column) {
                        return '<strong>' . $data['code'] . '</strong>';
                    },
                    'twigFilter' => 'raw'
                ],
                [
                    'attribute' =>'username',
                    'twigFilter' => 'reverse'
                ]

            ];

            $sortAttributes = [
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
            ];


            $paginationAttributes = [
                'defaultPageSize' => 45
            ];


            $dataProvider = [
                // 'queryBuilder' => $queryBuilder,
                'models' => \App\Entity\Customer\Customer::class,
                'sort' => $sortAttributes,
                'pagination' => $paginationAttributes
            ];

            $gridview = $this->createGridviewBuilder()
            ->setDataProvider($dataProvider)
            ->setColumns($columns)
            ->renderGridview();

            return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', []);
        }
    */
}
