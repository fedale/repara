<?php

namespace App\Controller\Gridview;

use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Entity\User\UserType;
use App\Service\GridSearchModel;
use Doctrine\ORM\EntityManagerInterface;
use Fedale\GridviewBundle\Contract\GridCrudHandlerInterface;
use Fedale\GridviewBundle\Crud\CrudButton;
use Fedale\GridviewBundle\Grid\Gridview;
use Fedale\GridviewBundle\Grid\GridviewBuilderFactory;
use App\Entity\User\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/gridview/user', name: 'gridview_user_')]
class UserController extends AbstractController
{
    /** Optional custom layout for the generated form; set to null for automatic rendering. */
    private const FORM_VIEW = 'gridview/user/_form.html.twig';

    public function __construct(
        private GridviewBuilderFactory $gridviewBuilderFactory,
        private GridSearchModel $searchModel,
        private EntityManagerInterface $entityManager,
        private GridCrudHandlerInterface $crud,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->buildGridview()->renderGrid('gridview/with_sidebar.html.twig');
    }

    /**
     * Add / edit / clone form. The form is generated from the columns' `control`
     * config (no hand-written FormType). On success returns a Turbo Stream that
     * replaces the grid frame.
     */
    #[Route('/form/{id}', name: 'form', methods: ['GET', 'POST'], defaults: ['id' => null])]
    public function form(Request $request, ?int $id): Response
    {
        $mode = $this->resolveMode($request, $id);

        $entity = null;
        if ($id !== null) {
            $entity = $this->entityManager->getRepository(User::class)->find($id);
            if ($entity === null) {
                throw $this->createNotFoundException();
            }
        }

        $gridview = $this->buildGridview();
        $columns  = $gridview->getColumns();

        $form = $this->crud->createForm(User::class, $columns, $mode, $entity, $request, [
            'cloneCallback' => static function (User $clone): void {
                // Unique fields must differ on a clone; collections stay prefilled.
                $clone->setCode('');
                $clone->setUsername('');
                $clone->setEmail('');
            },
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applyPassword($form, $mode);

            // save() returns null when a DB UNIQUE constraint slipped past
            // validation; fall through to re-render the form with the error.
            if ($this->crud->save($form, $mode) !== null) {
                $response = $gridview->renderGrid('@FedaleGridview/gridview/sections/_stream.html.twig');
                $response->headers->set('Content-Type', 'text/vnd.turbo-stream.html');

                return $response;
            }
        }

        $uniqueFields = [];
        foreach ($columns as $column) {
            if ($column->getControl() !== null && ($column->getControl()['unique'] ?? null) !== null) {
                $uniqueFields[] = $column->getAttribute();
            }
        }

        return new Response($this->crud->renderForm($form, $columns, self::FORM_VIEW, [
            'action' => $request->getRequestUri(),
            'mode'   => $mode,
            'validate' => [
                'checkUrl' => $this->generateUrl('gridview_user_exists'),
                'unique'   => $uniqueFields,
                // Only exclude the current row in edit; a clone is a new record.
                'id'       => $mode === GridCrudHandlerInterface::MODE_EDIT ? $id : null,
                'formName' => 'gridform',
            ],
        ]));
    }

    /** Live uniqueness check used by the gridview-form-validate Stimulus controller. */
    #[Route('/exists', name: 'exists', methods: ['GET'])]
    public function exists(Request $request): JsonResponse
    {
        $field = (string) $request->query->get('field');

        // Whitelist the fields exposed to the client check.
        if (!\in_array($field, ['code', 'username', 'email'], true)) {
            return new JsonResponse(['exists' => false]);
        }

        return new JsonResponse([
            'exists' => $this->crud->existsWithValue(
                User::class,
                $field,
                $request->query->get('value'),
                $request->query->get('id'),
            ),
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, int $id): Response
    {
        $entity = $this->entityManager->getRepository(User::class)->find($id);
        if ($entity === null) {
            throw $this->createNotFoundException();
        }

        // GET → render the confirmation recap into the modal.
        if ($request->isMethod('GET')) {
            return new Response($this->crud->renderDeleteConfirm(
                $entity,
                $this->buildGridview()->getColumns(),
                $this->generateUrl('gridview_user_delete', ['id' => $id]),
                $this->csrfTokenManager->getToken($this->crud->deleteTokenId($entity))->getValue(),
            ));
        }

        // POST → delete and refresh the grid via Turbo Stream.
        $this->crud->delete($entity, $request->request->get('_token'), $this->crud->deleteTokenId($entity));

        return $this->bulkStream();
    }

    #[Route('/bulk/delete', name: 'bulk_delete', methods: ['GET', 'POST'])]
    public function bulkDelete(Request $request): Response
    {
        $ids = $this->resolveBulkIds($request);

        if ($request->isMethod('GET')) {
            return new Response($this->crud->renderBulkDeleteConfirm(
                \count($ids),
                $request->getRequestUri(),
                $this->csrfTokenManager->getToken('gridcrud_bulk_delete')->getValue(),
            ));
        }

        if ($this->isCsrfTokenValid('gridcrud_bulk_delete', (string) $request->request->get('_token'))) {
            $this->crud->bulkDelete(User::class, $ids);
        }

        return $this->bulkStream();
    }

    #[Route('/bulk/update', name: 'bulk_update', methods: ['GET', 'POST'])]
    public function bulkUpdate(Request $request): Response
    {
        $ids     = $this->resolveBulkIds($request);
        $columns = $this->buildGridview()->getColumns();
        $form    = $this->crud->createBatchForm($columns);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->crud->applyBatch(User::class, $ids, $form, $columns);

            return $this->bulkStream();
        }

        return new Response($this->crud->renderBatchForm($form, \count($ids), $request->getRequestUri()));
    }

    #[Route('/inline/{id}/{field}', name: 'inline', methods: ['GET', 'POST'], requirements: ['id' => '\d+', 'field' => '[a-zA-Z_]+'])]
    public function inline(Request $request, int $id, string $field): Response
    {
        $entity = $this->entityManager->getRepository(User::class)->find($id);
        if ($entity === null) {
            throw $this->createNotFoundException();
        }

        // Only columns explicitly marked editable may be edited inline.
        $column = null;
        foreach ($this->buildGridview()->getColumns() as $c) {
            if ($c->getAttribute() === $field && $c->isEditable()) {
                $column = $c;
                break;
            }
        }
        if ($column === null) {
            throw $this->createNotFoundException();
        }

        $action = $this->generateUrl('gridview_user_inline', ['id' => $id, 'field' => $field]);

        if ($request->isMethod('GET')) {
            return new Response($this->crud->renderInlineEditor(User::class, $column, $entity, $action));
        }

        $result = $this->crud->saveInline(User::class, $column, $entity, $request, $action);

        return new Response($result['body'], $result['ok'] ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Resolves the target ids: explicit `ids[]` from the query, or all-mode
     * (`all=1`) resolved server-side by re-running the filtered search.
     *
     * @return int[]
     */
    private function resolveBulkIds(Request $request): array
    {
        if ($request->query->getBoolean('all')) {
            $params = $request->query->all('myform'); // filter form name (default)
            $qb = $this->entityManager->getRepository(User::class)->search($params);
            $qb->select('DISTINCT u.id')->setFirstResult(null)->setMaxResults(null);

            return array_map(static fn(array $row) => (int) $row['id'], $qb->getQuery()->getScalarResult());
        }

        return array_map('intval', (array) $request->query->all('ids'));
    }

    private function bulkStream(): Response
    {
        $response = $this->buildGridview()->renderGrid('@FedaleGridview/gridview/sections/_stream.html.twig');
        $response->headers->set('Content-Type', 'text/vnd.turbo-stream.html');

        return $response;
    }

    private function resolveMode(Request $request, ?int $id): string
    {
        if ($id === null) {
            return GridCrudHandlerInterface::MODE_ADD;
        }

        return $request->query->get('mode') === GridCrudHandlerInterface::MODE_CLONE
            ? GridCrudHandlerInterface::MODE_CLONE
            : GridCrudHandlerInterface::MODE_EDIT;
    }

    /** Hashes the submitted plain password for new users (mirrors the app's CRUD scaffold). */
    private function applyPassword(\Symfony\Component\Form\FormInterface $form, string $mode): void
    {
        if (!\in_array($mode, [GridCrudHandlerInterface::MODE_ADD, GridCrudHandlerInterface::MODE_CLONE], true)) {
            return;
        }

        /** @var User $user */
        $user  = $form->getData();
        // The plainPassword control is required in add/clone, so it is present.
        $plain = (string) $form->get('plainPassword')->getData();
        $user->setPassword($this->passwordHasher->hashPassword($user, $plain));
    }

    private function buildGridview(): Gridview
    {
        return $this->gridviewBuilderFactory->createGridviewBuilder()
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
            ->setColumns($this->buildColumns())
            ->setOptions([
                'routeName' => 'gridview_user_index',
                'crud' => [
                    'title'         => 'Utente',
                    'addUrl'        => $this->generateUrl('gridview_user_form'),
                    'bulkDeleteUrl' => $this->generateUrl('gridview_user_bulk_delete'),
                    'bulkUpdateUrl' => $this->generateUrl('gridview_user_bulk_update'),
                    // Base for inline editing; the JS appends /{id}/{field}.
                    'inlineUrl'     => $this->generateUrl('gridview_user_index') . '/inline',
                ],
                'addLabel' => 'Nuovo utente',
                'layout' => [
                    'gridview' => '{toolbar} {bulkBar} {header} {table} {footer}',
                    'toolbar'  => '{addButton}',
                ],
            ])
            ->setAttributes(['class' => 'table'])
            ->renderGridview();
    }

    /**
     * @return array<int, mixed>
     */
    private function buildColumns(): array
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

        return [
            // selection checkbox (enables bulk actions)
            ['type' => 'checkbox'],
            // id (integer)
            'id',
            // code (string)
            [
                'attribute' => 'code',
                'label' => 'Codice',
                'filter' => ['type' => 'text'],
                'filterBar' => true,
                'showInDeleteConfirm' => true,
                'editable' => true,
                'control' => [
                    'type' => 'text',
                    'required' => true,
                    'requiredMessage' => 'Il codice è obbligatorio.',
                    'unique' => true,
                    'uniqueMessage' => 'Esiste già un utente con questo codice.',
                ],
            ],
            // username (string)
            [
                'attribute' => 'username',
                'label' => 'Username',
                'filter' => ['type' => 'text'],
                'filterBar' => true,
                'showInDeleteConfirm' => true,
                'editable' => true,
                'control' => [
                    'type' => 'text',
                    'required' => true,
                    'requiredMessage' => 'Lo username è obbligatorio.',
                    'unique' => true,
                    'uniqueMessage' => 'Username già in uso.',
                ],
            ],
            // plainPassword — write-only control, required only when creating.
            [
                'attribute' => 'plainPassword',
                'label' => 'Password',
                'visible' => false,
                'sortable' => false,
                'filterable' => false,
                'control' => [
                    'type' => 'text',
                    'modes' => ['add', 'clone'],
                    'required' => true,
                    'requiredMessage' => 'La password è obbligatoria.',
                ],
            ],
            // profile (OneToOne) — fullname (display only, no control)
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
                'showInDeleteConfirm' => true,
                'editable' => true,
                'control' => [
                    'type' => 'text',
                    'required' => true,
                    'requiredMessage' => "L'e-mail è obbligatoria.",
                    'unique' => true,
                    'uniqueMessage' => 'Esiste già un utente con questa e-mail.',
                ],
            ],
            // type (ManyToOne) — relation control binds a managed UserType entity
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'type' => 'relation',
                'value' => fn(array $data) => $data['type']['name'] ?? '—',
                'filter' => ['options' => ['choices' => $typeChoices, 'multiple' => true, 'searchable' => true]],
                'filterBar' => true,
                'batchUpdate' => true,
                'editable' => true,
                'control' => ['options' => ['class' => UserType::class, 'choice_label' => 'name']],
            ],
            // groups (ManyToMany) — multi relation control
            [
                'attribute' => 'groups',
                'label' => 'Gruppi',
                'type' => 'relation',
                'value' => fn(array $data) => implode(
                    ', ',
                    array_map(fn(array $group) => $group['name'], $data['groups'] ?? [])
                ),
                'filter' => ['options' => ['choices' => $groupChoices, 'multiple' => true, 'searchable' => true]],
                'control' => ['options' => ['class' => UserGroup::class, 'choice_label' => 'name', 'multiple' => true]],
            ],
            // roles — editable via getter/setter: getRoles() follows the Security
            // contract (string[]), so the form binds to the UserRole collection
            // through getRoleEntities()/addRole() instead of PropertyAccess.
            [
                'attribute' => 'roles',
                'label' => 'Ruoli',
                'type' => 'relation',
                'filter' => ['options' => ['choices' => $roleChoices, 'multiple' => true, 'searchable' => true]],
                'value' => fn(array $data) => implode(', ', $data['roles'] ?? []),
                'control' => ['options' => [
                    'class' => UserRole::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'getter' => fn(User $u) => $u->getRoleEntities(),
                    'setter' => function (User $u, $roles): void {
                        $u->getRoleEntities()->clear();
                        foreach ($roles as $role) {
                            $u->addRole($role);
                        }
                    },
                ]],
            ],
            // active (boolean) — checkbox control (not required, else it must be checked)
            [
                'attribute' => 'active',
                'label' => 'Attivo',
                'type' => 'boolean',
                'filter' => true,
                'filterBar' => true,
                'batchUpdate' => true,
                'editable' => true,
                'control' => ['required' => false],
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
                'filter' => true,
            ],
            // actions — add/edit/clone/delete wired to the CRUD modal
            [
                'type' => 'action',
                'label' => 'Azioni',
                'layout' => '{edit} {clone} {delete}',
                'buttons' => [
                    'edit' => fn(array $row) => CrudButton::edit(
                        $this->generateUrl('gridview_user_form', ['id' => $row['id']])
                    ),
                    'clone' => fn(array $row) => CrudButton::clone(
                        $this->generateUrl('gridview_user_form', ['id' => $row['id'], 'mode' => 'clone'])
                    ),
                    'delete' => fn(array $row) => CrudButton::delete(
                        $this->generateUrl('gridview_user_delete', ['id' => $row['id']])
                    ),
                ],
            ],
        ];
    }
}
