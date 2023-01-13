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
    public function grid(EntityManagerInterface $entityManager, EntityDataProvider $dataProvider): Response
    {
        /**
         *
         */
        $columns = [
            'id', // it's a string so it's a ColumnData
            // [
            //    'type' => 'serial', // array with SerialColumn
            //    'visible' => rand(0, 10) > 5 ? true : false
            // ],
            [
                'value' => function(array $data, string $key, ColumnInterface $column) {
                    return '<strong>' . $data['profile']['firstname'] . '</strong>';
                },
                'twigFilter' => 'raw'
            ],
            [
                'value' => function(array $data, string $key, ColumnInterface $column) {
                    return $data['profile']['lastname'];
                },
            ],
            [
            //    'attribute' => 'email',
               'label' => 'E-Mail',
               'value' => function (array $data, string $key, ColumnInterface $column) {
                    return '<strong>' . $data['email'] . '</strong>';
                },
                'twigFilter' => 'upper'
            ],
            // [
            //     'value' => function (array $data, string $key, ColumnInterface $column) {
            //         return $data['profile']['fullname'];
            //     },
            //     'label' => 'Fullname'
            // ],
            'code:text:codice',
            // 'fullcode',
            // 'username:text:nome utente',
            // [
            //     'type' => 'action'
            // ]
           // 'profile.firstname:text:profile'
        ];

        $queryBuilder = $entityManager
            ->getRepository(\App\Entity\Customer\Customer::class)
            ->createQueryBuilder('c')
            ->select('c ', 'p', 'l')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
            ;

        $dataProvider->setQueryBuilder($queryBuilder);

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
