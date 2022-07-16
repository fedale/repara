<?php

namespace App\DataFixtures\User;

use App\Entity\User\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserRoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getRoles() as $k => $role) {
            $item = new UserRole();
            $item->setName($role['name']);
            $item->setCode($role['code']);
            $manager->persist($item);
        }

        $manager->flush();
    }

    private function getRoles() {
        return [
            [
                'name' => 'Admin',
                'code' => 'ROLE_ADMIN',
            ],
            [
                'name' => 'Super Admin',
                'code' => 'ROLE_SUPERADMIN',
            ],
            [
                'name' => 'Staff',
                'code' => 'ROLE_STAFF',
            ],
            [
                'name' => 'Editor',
                'code' => 'ROLE_EDITOR',
            ],
            [
                'name' => 'Moderator',
                'code' => 'ROLE_MODERATOR',
            ],
        ];
    }
}
