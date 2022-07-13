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
        
        foreach ($this->getUsers() as $k => $item) {
            $u = $item['user'];
            $p = $item['profile'];

            $user = new User();
            $user->setUsername($u['username']);
            $user->setCode($u['code']);
            $user->setEmail($u['email']);
            $user->setPassword($u['password']);
            $manager->persist($user);

            $profile = new UserProfile();
            $profile->setFirstname($p['firstname']);
            $profile->setLastname($p['lastname']);
            $profile->setUser($user);
            $manager->persist($profile);    
        }
        
        $manager->flush();
    }

    private function getUsers() {
        return [
            [
                'user' => [
                    'username' => 'danilo',
                    'code' => 'danilo',
                    'email' => 'danilo@ipercollege.it',
                    'password' => '$2y$13$TqzoavfROVsl5vHL6bxHSuRCzUz7jiwsYjAoiNb2vuu9/ej.JN6Ra', // danilo123
                ],
                'profile' => [
                    'firstname' => 'Danilo',
                    'lastname' => 'Di Moia',
                ]
            ],
            [
                'user' => [
                    'username' => 'admin',
                    'code' => 'admin',
                    'email' => 'admin@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Admin',
                    'lastname' => 'Di Moia',
                ]
            ],
        ];

    }
}
