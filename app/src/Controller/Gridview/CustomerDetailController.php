<?php
namespace App\Controller\Gridview;

use App\Entity\Customer\Customer;
use Fedale\GridviewBundle\Controller\AbstractDetailController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customer-detail', name: 'customer_detail_')]
class CustomerDetailController extends AbstractDetailController
{
    protected function getDataClass(): string
    {
        return Customer::class;
    }

    protected function buildColumns(): array
    {
        return [
            'id',
            ['attribute' => 'code', 'label' => 'Codice'],
            [
                'attribute' => 'profile_fullname',
                'label' => 'Nominativo',
                'value' => fn(array $d) => $d['profile']['fullname'] ?? '—'
            ],
            ['attribute' => 'email', 'label' => 'E-mail'],
            ['attribute' => 'active', 'label' => 'Attivo', 'type' => 'boolean'],
            ['attribute' => 'createdAt', 'label' => 'Creato il', 'twigFilter' => "date('d/m/Y')"],
        ];
    }
}
