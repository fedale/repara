<?php

namespace App\Controller;

use App\Service\GridviewModel;
use App\Service\SearchModel;
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
    ) {
    }

    #[Route('/gridview', name: 'app_gridview', methods: ['GET'])]
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
                'filter' => [
                    'type' => 'boolean',
                ]
                /*'filter' => [
                    'type' => 'text',
                    'options' => []
                ],*/
            ],
            [
               'attribute' => 'email',
               'label' => 'email',
               'value' => function (array $data, string $key, ColumnInterface $column) {
                    return '<strong>' . $data['email'] . '</strong>';
                },
                'twigFilter' => 'raw',
                'filter' => [
                    'type' => 'choice', 
                    'options' => [
                            'choices'  => [
                            'Maybe' => null,
                            'Yes' => true,
                            'No' => false,
                        ],
                    ],
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
        $dataProvider->setSort($sort);

        $searchModel = new SearchModel();

        // Order matters! Try to switch setColumns() / setFilterModel()
        $gridview = $this->createGridviewBuilder()
            ->setSearchModel($searchModel)
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

        return $gridview->renderGrid('@FedaleGridview/gridview/index.html.twig', ['pagination' => $pagination]); //, 'form' => $form->createView()]);
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
