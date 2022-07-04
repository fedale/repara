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
        $ac1 = new AccessControl();
        $ac1->setName('Login');
        $ac1->setPath('^/admin/login');
        $ac1->setRoles('PUBLIC_ACCESS');
        $ac1->setSort(1);
        $manager->persist($ac1);

        $ac2 = new AccessControl();
        $ac2->setName('Logout');
        $ac2->setPath('^/admin/logout');
        $ac2->setRoles('IS_AUTHENTICATED_FULLY');
        $ac2->setSort(2);
        $manager->persist($ac2);

        $ac3 = new AccessControl();
        $ac3->setName('Admin area');
        $ac3->setPath('^/');
        $ac3->setRoles('IS_AUTHENTICATED_FULLY');
        $ac3->setSort(1000);
        $manager->persist($ac3);

        $manager->flush();
    }
}
