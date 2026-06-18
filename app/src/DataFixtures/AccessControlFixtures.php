<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Fedale\AccessControlBundle\Bridge\Doctrine\Entity\AccessControlEntity;

/**
 * Regole di accesso seedate per fedale/access-control-bundle.
 *
 * Con default_policy: deny servirebbe una regola allow per rendere il sito
 * raggiungibile: questa regola consente l'intero sito (^/) replicando il
 * comportamento demo precedente (PUBLIC_ACCESS è concesso a tutti, anche
 * agli utenti anonimi).
 */
class AccessControlFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getRules() as $rule) {
            $entity = (new AccessControlEntity())
                ->setName($rule['name'])
                ->setPath($rule['path'])
                ->setRoles($rule['roles'])
                ->setMethods($rule['methods'])
                ->setIps($rule['ips'])
                ->setAllow($rule['allow'])
                ->setSort($rule['sort'])
                ->setActive($rule['active']);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function getRules(): array
    {
        return [
            [
                'name' => 'Admin area',
                'path' => '^/',
                'roles' => ['PUBLIC_ACCESS'],
                'methods' => [],
                'ips' => [],
                'allow' => true,
                'sort' => 1000,
                'active' => true,
            ],
        ];
    }
}
