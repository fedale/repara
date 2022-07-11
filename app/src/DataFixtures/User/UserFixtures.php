<?php

namespace App\DataFixtures\User;

use App\Entity\User\User;
use App\Entity\User\UserProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setUsername('danilo');
        $user1->setCode('danilo');
        $user1->setEmail('danilo@ipercollege.it');
        $password = $this->hasher->hashPassword($user1, 'danilo123');
        $user1->setPassword($password);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('admin');
        $user2->setCode('admin');
        $user2->setEmail('admin@ipercollege.it');
        $password = $this->hasher->hashPassword($user2, 'admin123');
        $user2->setPassword($password);
        $manager->persist($user2);
        
        $manager->flush();

        $userProfile1 = new UserProfile();
        $userProfile1->setFirstname('Danilo');
        $userProfile1->setLastname('Di Moia');
        $userProfile1->setUser($user1);
        $manager->persist($userProfile1);

        $userProfile2 = new UserProfile();
        $userProfile2->setFirstname('Admin');
        $userProfile2->setLastname('Di Moia');
        $userProfile2->setUser($user2);
        $manager->persist($userProfile2);

        $manager->flush();
    }
}
