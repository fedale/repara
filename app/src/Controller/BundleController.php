<?php

namespace App\Controller;

use App\Service\CustomerSearchModel;
use Fedale\GridviewBundle\Column\ColumnInterface;
use Fedale\GridviewBundle\Component\Pagination;
use Fedale\GridviewBundle\DataProvider\EntityDataProvider;
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Fedale\CalendarBundle\Calendar\CalendarBuilderFactory;
use Fedale\CalendarBundle\Calendar\CalendarBuilderInterface;
use Fedale\GridviewBundle\Component\PaginationInterface;
use Fedale\GridviewBundle\Component\Sort;
use Fedale\GridviewBundle\Component\SortInterface;
use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Fedale\GridviewBundle\Grid\GridviewBuilderInterface;

#[Route('/bundle')]
class BundleController extends AbstractController
{
    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
        private CalendarBuilderFactory $calendarBuilderFactory,
        private CustomerSearchModel $customerSearchModel
    ) {
    }

    #[Route('/gridview', name: 'app_gridview', methods: ['GET'])]
    public function grid(
        Request $request
    ): Response
    {
  //      $pagination->setDefaultPageSize(10);

        $paginationAttributes = [
            'defaultPageSize' => 10
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
        ];

        /**
         *
         */
        $columns = [
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
                'value' => function(array $data, string $key, ColumnInterface $column) {
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
                ]
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
        $gridview = $this->createGridviewBuilder()
            ->setSearchModel($this->customerSearchModel)
            ->setDataProvider($dataProvider)
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

        return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', []);//, ['pagination' => $pagination]); //, 'form' => $form->createView()]);
    }

    #[Route('/calendar', name: 'app_calendar', methods: ['GET'])]
    public function calendar(EntityManagerInterface $entityManager, EntityDataProvider $dataProvider, Sort $sort, Pagination $pagination): Response
    {
        $calendar = $this->createCalendarBuilder()
            ->renderCalendar();
        ;

        return $calendar->renderCalendar('@FedaleCalendar/calendar/index.html.twig');
    }
    
    public function createGridviewBuilder(): GridviewBuilderInterface
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }

    public function createCalendarBuilder(): CalendarBuilderInterface
    {
        return $this->calendarBuilderFactory->createCalendarBuilder();
    }
}
