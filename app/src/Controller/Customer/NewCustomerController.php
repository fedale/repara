<?php

namespace App\Controller\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType as CustomerCustomerType;
use App\Form\Customer\CustomerRegistrationType;
use App\Form\Customer\CustomerType;
use App\Form\Model\CustomerCreateModel;
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
        $columns2 = [
            'code',
            [
                'attribute' => 'code',
                'type' => 'serial',
                'visible' => true,
                'label' => 'code',
            ],
            [
                'attribute' => 'username',
                'visible' => true,
                'label' => 'username'
            ],
            [
                'attribute' => 'email',
                'type' => 'serial',
                'visible' => true,
                'label' => 'email'
            ],
            [
                'attribute' => 'email',
                'type' => 'serial',
                'value' => 'my custom value',
                'visible' => true,
                'label' => 'profile'
            ],
        ];
        $columns = [
            'id',
            'code',
            'email',
            'fullcode',
            'username:text:nome utente',
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

        // dump($queryBuilder, $gridview);

        return $gridview->renderGrid('new-customer/index.html.twig');
    }
    
    public function createGridviewBuilder(): GridviewBuilder
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}
