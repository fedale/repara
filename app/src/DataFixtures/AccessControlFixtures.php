<?php

namespace App\DataFixtures;

use App\Entity\AccessControl;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccessControlFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'access-control';

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getAccessRoles() as $accessRole) {
            $ac = new AccessControl();
            $ac->setName($accessRole['name']);
            $ac->setPath($accessRole['path']);
            $ac->setRoles($accessRole['roles']);
            $ac->setSort($accessRole['sort']);
            $manager->persist($ac);
        }
        
        $manager->flush();
    }

    private function getAccessRoles(): array
    {
        return [
            [
                'name' => 'Admin area',
                'path' => '^/',
                'roles' => 'PUBLIC_ACCESS',
                'sort' => 1000
            ],
        ];
    }
}
