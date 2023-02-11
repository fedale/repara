<?php

namespace App\Controller;

use App\Grid\Component\Pagination;
use App\Grid\DataProvider\EntityDataProvider;
use App\Grid\GridviewBuilder;
use App\Grid\GridviewBuilderFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssetController extends AbstractController
{
    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
        private EntityManagerInterface $entityManager,
        private EntityDataProvider $dataProvider,
        private Pagination $pagination
    ) {}

    #[Route('/asset', name: 'app_asset')]
    public function index(): Response
    {
        $columns = [
            'id',
            'name',
            'slug',
            'active'
        ];

        $queryBuilder = $this->entityManager
                ->getRepository(\App\Entity\Asset\Asset::class)
                ->createQueryBuilder('a')
                ->setMaxResults(20)
                ->setFirstResult(0)
                ->getQuery()
                ->getResult()
                ;

                dump($queryBuilder);
        
        $this->dataProvider->setQueryBuilder($queryBuilder);

        $gridview = $this->createGridviewBuilder()
            ->setDataProvider($this->dataProvider)
            ->setColumns($columns)
            ->renderGridview();
        ;

        return $gridview->renderGrid('new-customer/index.html.twig', ['pagination' => $this->pagination]);
    }

    public function createGridviewBuilder(): GridviewBuilder
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}
