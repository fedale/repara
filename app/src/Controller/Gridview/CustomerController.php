<?php

namespace App\Controller\Gridview;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerType;
use App\Repository\Customer\CustomerLocationRepository;
use App\Service\GridSearchModel;
use Doctrine\ORM\EntityManagerInterface;
use Fedale\GridviewBundle\Contract\GridviewBuilderInterface;
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gridview/customer', name: 'gridview_customer_')]
class CustomerController extends AbstractController
{
    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
        private GridSearchModel $searchModel,
        private EntityManagerInterface $entityManager,
        private CustomerLocationRepository $locationRepository,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $typeChoices = [];
        foreach ($this->entityManager->getRepository(CustomerType::class)->findAll() as $type) {
            $typeChoices[$type->getName()] = $type->getId();
        }

        $locationChoices = [];
        foreach ($this->locationRepository->findAll() as $location) {
            $locationChoices[$location->getCity() . ' — ' . $location->getName()] = $location->getId();
        }

        $columns = [
            // id (integer)
            'id',
            // code (string)
            [
                'attribute' => 'code',
                'label'     => 'Codice',
                'filter'    => ['type' => 'text'],
                'filterBar' => true,
            ],
            // profile (OneToOne) — fullname
            [
                'attribute' => 'profile_fullname',
                'label'     => 'Nominativo',
                'value'     => fn (array $data) => $data['profile']['fullname'] ?? '—',
                'filter'    => ['type' => 'text'],
                'filterBar' => true,
            ],
            // email (string)
            [
                'attribute' => 'email',
                'label'     => 'E-mail',
                'filter'    => ['type' => 'text'],
                'filterBar' => true,
            ],
            // type (ManyToOne)
            [
                'attribute' => 'type',
                'label'     => 'Tipo',
                'value'     => fn (array $data) => $data['type']['name'] ?? '—',
                'filter'    => [
                    'type'    => 'relation',
                    'options' => ['choices' => $typeChoices, 'multiple' => true, 'searchable' => true],
                ],
                'filterBar' => true,
            ],
            // locations (OneToMany)
            [
                'attribute' => 'locations',
                'label'     => 'Sedi',
                'value'     => fn (array $data) => implode(
                    ', ',
                    array_map(fn (array $location) => $location['name'], $data['locations'] ?? [])
                ),
                'filter'    => [
                    'type'    => 'relation',
                    'options' => ['choices' => $locationChoices, 'multiple' => true, 'searchable' => true],
                ],
                'filterBar' => true,
            ],
            // active (boolean)
            [
                'attribute' => 'active',
                'label'     => 'Attivo',
                'value'     => fn (array $data) => $data['active'] ? 'Sì' : 'No',
                'filter'    => ['type' => 'boolean'],
                'filterBar' => true,
            ],
            // createdAt (datetime)
            [
                'attribute'  => 'createdAt',
                'label'      => 'Creato il',
                'twigFilter' => "date('d/m/Y')",
                'filter'     => ['type' => 'date'],
            ],
        ];

        $gridview = $this->createGridviewBuilder()
            ->setId('customer')
            ->setSearchModel($this->searchModel)
            ->setDataProvider([
                'models'     => Customer::class,
                'pagination' => ['defaultPageSize' => 20],
                'sort'       => [
                    'id'    => ['asc' => ['c.id'], 'desc' => ['c.id'], 'default' => 'desc'],
                    'code'  => ['asc' => ['c.code'], 'desc' => ['c.code'], 'default' => 'asc'],
                    'email' => ['asc' => ['c.email'], 'desc' => ['c.email'], 'default' => 'asc'],
                ],
            ])
            ->setColumns($columns)
            ->setAttributes(['class' => 'table'])
            ->renderGridview();

        return $gridview->renderGrid('gridview/with_sidebar.html.twig');
    }

    private function createGridviewBuilder(): GridviewBuilderInterface
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder();
    }
}
