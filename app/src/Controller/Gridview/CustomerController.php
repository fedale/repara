<?php

namespace App\Controller\Gridview;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerType;
use App\Repository\Customer\CustomerLocationRepository;
use Fedale\GridviewBundle\Controller\AbstractGridController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gridview/customer', name: 'gridview_customer_')]
class CustomerController extends AbstractGridController
{
    public function __construct(
        private CustomerLocationRepository $locationRepository,
    ) {
    }

    protected function getDataClass(): string
    {
        return Customer::class;
    }

    // Grid id default ("customer") derived from the entity short name; no configure() needed.

    protected function getDataProviderConfig(): array
    {
        return [
            'models' => Customer::class,
            'pagination' => ['defaultPageSize' => 20],
            'sort' => [
                'id' => ['asc' => ['c.id'], 'desc' => ['c.id'], 'default' => 'desc'],
                'code' => ['asc' => ['c.code'], 'desc' => ['c.code'], 'default' => 'asc'],
                'email' => ['asc' => ['c.email'], 'desc' => ['c.email'], 'default' => 'asc'],
            ],
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected function buildColumns(): array
    {
        $typeChoices = [];
        foreach ($this->em()->getRepository(CustomerType::class)->findAll() as $type) {
            $typeChoices[$type->getName()] = $type->getId();
        }

        $locationChoices = [];
        foreach ($this->locationRepository->findAll() as $location) {
            $locationChoices[$location->getCity() . ' — ' . $location->getName()] = $location->getId();
        }

        return [
            // id (integer)
            'id',
            // code (string)
            [
                'attribute' => 'code',
                'label' => 'Codice',
                'filter' => ['type' => 'text'],
                // 'filterBar' => true,
            ],
            // profile (OneToOne) — fullname
            [
                'attribute' => 'profile_fullname',
                'label' => 'Nominativo',
                'value' => fn(array $data) => $data['profile']['fullname'] ?? '—',
                'filter' => ['type' => 'text'],
                // 'filterBar' => true,
            ],
            // email (string)
            [
                'attribute' => 'email',
                'label' => 'E-mail',
                'filter' => ['type' => 'text'],
                // 'filterBar' => true,
            ],
            // type (ManyToOne)
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'value' => fn(array $data) => $data['type']['name'] ?? '—',
                'filter' => [
                    'type' => 'relation',
                    'options' => ['choices' => $typeChoices, 'multiple' => true, 'searchable' => true],
                ],
                // 'filterBar' => true,
            ],
            // locations (OneToMany)
            [
                'attribute' => 'locations',
                'label' => 'Sedi',
                'value' => fn(array $data) => implode(
                    ', ',
                    array_map(fn(array $location) => $location['name'], $data['locations'] ?? [])
                ),
                'filter' => [
                    'type' => 'relation',
                    'options' => ['choices' => $locationChoices, 'multiple' => true, 'searchable' => true],
                ],
                // 'filterBar' => true,
            ],
            // active (boolean)
            [
                'attribute' => 'active',
                'label' => 'Attivo',
                'value' => fn(array $data) => $data['active'] ? 'Sì' : 'No',
                'filter' => ['type' => 'boolean'],
                // 'filterBar' => true,
            ],
            // createdAt (datetime)
            [
                'attribute' => 'createdAt',
                'label' => 'Creato il',
                'twigFilter' => "date('d/m/Y')",
                'filter' => ['type' => 'date'],
            ],
        ];
    }
}
