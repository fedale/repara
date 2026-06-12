<?php

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * QueryBuilder consumed by the gridview EntityDataProvider. The param keys
     * mirror the column attributes (dots replaced by underscores) declared in
     * the Gridview controller.
     */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this
            ->createQueryBuilder('u')
            ->select('u', 'p', 't', 'g', 'r')
            ->distinct()
            ->leftJoin('u.profile', 'p')
            ->leftJoin('u.type', 't')
            ->leftJoin('u.groups', 'g')
            ->leftJoin('u.roles', 'r')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'code'      => ['text',     'u.code'],
            'username'  => ['text',     'u.username'],
            'email'     => ['text',     'u.email'],
            'active'    => ['boolean',  'u.active'],
            'type'      => ['relation', 't.id'],
            'groups'    => ['relation', 'g.id'],
            'roles'     => ['relation', 'r.id'],
            'createdAt' => ['date',     'u.createdAt'],
        ]);

        // Fullname matches first/last name or username
        $this->searchForm->andFilterWhere(
            $qb,
            'or',
            ['ilike', 'p.firstname', $params['profile_fullname'] ?? null],
            ['ilike', 'p.lastname', $params['profile_fullname'] ?? null],
            ['ilike', 'CONCAT(p.firstname, \' \', p.lastname)', $params['profile_fullname'] ?? null],
            ['ilike', 'u.username', $params['profile_fullname'] ?? null],
        );

        return $qb;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function loadUserByIdentifier(string $usernameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
                'SELECT u
                FROM App\Entity\User\User u
                JOIN App\Entity\User\UserRole ur
                WHERE u.username = :query
                OR u.email = :query'
            )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

    /** @deprecated since Symfony 5.3 */
    public function loadUserByUsername(string $usernameOrEmail): ?User
    {
        return $this->loadUserByIdentifier($usernameOrEmail);
    }

    public function findWithProfileAndGroups()
    {
        return $this->createQueryBuilder('e')
            ->addSelect('p')
            ->addSelect('g')
            ->addSelect('c')
            ->join('e.profile', 'p')
            ->leftJoin('e.groups', 'g')
            ->leftJoin('e.assignedCustomers', 'c')
            ->orderBy('e.lastname', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

  
}
