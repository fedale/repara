<?php

namespace App\Controller\Gridview;

use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Entity\User\UserType;
use App\Service\GridSearchModel;
use Doctrine\ORM\EntityManagerInterface;
use Fedale\GridviewBundle\Contract\GridviewBuilderInterface;
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;
use App\Entity\User\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gridview/user', name: 'gridview_user_')]
class UserController extends AbstractController
{
    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
        private GridSearchModel $searchModel,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $typeChoices = [];
        foreach ($this->entityManager->getRepository(UserType::class)->findAll() as $type) {
            $typeChoices[$type->getName()] = $type->getId();
        }

        $groupChoices = [];
        foreach ($this->entityManager->getRepository(UserGroup::class)->findAll() as $group) {
            $groupChoices[$group->getName()] = $group->getId();
        }

        $roleChoices = [];
        foreach ($this->entityManager->getRepository(UserRole::class)->findAll() as $role) {
            $roleChoices[$role->getName()] = $role->getId();
        }

        $columns = [
            // id (integer)
            'id',
            // code (string)
            [
                'attribute' => 'code',
                'label' => 'Codice',
                'filter' => ['type' => 'text'],
                'filterBar' => true,
            ],
            // username (string)
            [
                'attribute' => 'username',
                'label' => 'Username',
                'filter' => ['type' => 'text'],
                'filterBar' => true,
            ],
            // profile (OneToOne) — fullname
            [
                'attribute' => 'profile_fullname',
                'label' => 'Nominativo',
                'value' => fn(array $data) => $data['profile']['fullname'] ?? '—',
                'filter' => ['type' => 'text'],
                'filterBar' => true,
            ],
            // email (string)
            [
                'attribute' => 'email',
                'label' => 'E-mail',
                'filter' => ['type' => 'text'],
                'filterBar' => true,
            ],
            // type (ManyToOne)
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'type' => 'relation',
                'value' => fn(array $data) => $data['type']['name'] ?? '—',
                // filter inherits the root type (relation); only options are given
                'filter' => ['options' => ['choices' => $typeChoices, 'multiple' => true, 'searchable' => true]],
                'filterBar' => true,
            ],
            // groups (ManyToMany)
            [
                'attribute' => 'groups',
                'label' => 'Gruppi',
                'type' => 'relation',
                'value' => fn(array $data) => implode(
                    ', ',
                    array_map(fn(array $group) => $group['name'], $data['groups'] ?? [])
                ),
                // filter inherits the root type (relation); only options are given
                'filter' => ['options' => ['choices' => $groupChoices, 'multiple' => true, 'searchable' => true]],
                //'filterBar' => true,
            ],
            // roles (security roles, array of strings)
            [
                'attribute' => 'roles',
                'label' => 'Ruoli',
                'type' => 'relation',
                'filter' => ['options' => ['choices' => $roleChoices, 'multiple' => true, 'searchable' => true]],
                'value' => fn(array $data) => implode(', ', $data['roles'] ?? []),
            ],
            // active (boolean) — type at root drives ✓/✗ rendering AND the filter type
            [
                'attribute' => 'active',
                'label' => 'Attivo',
                'type' => 'boolean',
                'filter' => true, // inherits the root type (boolean)
                'filterBar' => true,
            ],
            // lastLoginAt (unix timestamp)
            [
                'attribute' => 'lastLoginAt',
                'label' => 'Ultimo accesso',
                'value' => fn(array $data) => !empty($data['lastLoginAt'])
                    ? date('d/m/Y H:i', $data['lastLoginAt'])
                    : '—',
            ],
            // createdAt (datetime)
            [
                'attribute' => 'createdAt',
                'label' => 'Creato il',
                'type' => 'date',
                'twigFilter' => "date('d/m/Y')",
                'filter' => true, // inherits the root type (date)
            ],
        ];

        $gridview = $this->createGridviewBuilder()
            ->setId('user')
            ->setSearchModel($this->searchModel)
            ->setDataProvider([
                'models' => User::class,
                'pagination' => ['defaultPageSize' => 20],
                'sort' => [
                    'id' => ['asc' => ['u.id'], 'desc' => ['u.id'], 'default' => 'desc'],
                    'username' => ['asc' => ['u.username'], 'desc' => ['u.username'], 'default' => 'asc'],
                    'email' => ['asc' => ['u.email'], 'desc' => ['u.email'], 'default' => 'asc'],
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
