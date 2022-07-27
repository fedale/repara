<?php

namespace App\DataFixtures\User;

use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Entity\User\UserProfile;
use App\Entity\User\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $userRoleRepository = $manager->getRepository(UserRole::class);
        $userGroupRepository = $manager->getRepository(UserGroup::class);
        
        foreach ($this->getUsers() as $k => $item) {
            $u = $item['user'];
            $p = $item['profile'];

            $user = new User();
            $user->setUsername($u['username']);
            $user->setCode($u['code']);
            $user->setEmail($u['email']);
            $user->setPassword($u['password']);
            
            // Check for role
            if (array_key_exists('roles', $item) && count($item['roles']) > 0 ) {
                foreach ($item['roles'] as $k => $code) {
                    $role = $userRoleRepository->findOneBy(['code' => $code]);
                    if (!is_null($role)) {
                        $user->addRole($role);
                    }
                }
            }

            // Check for group
            if (array_key_exists('groups', $item) && count($item['groups']) > 0 ) {
                foreach ($item['groups'] as $k => $name) {
                    $group = $userGroupRepository->findOneBy(['name' => $name]);
                    if (!is_null($group)) {
                        $user->addGroup($group);
                    }
                }
            }

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
                ],
                'roles' => ['ROLE_ADMIN', 'ROLE_SUPERADMIN'],
                'groups' => ['Group 1', 'Group 2', 'Group 5']
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
                ],
                'roles' => ['ROLE_ADMIN'],
                'groups' => ['Group 3']
            ],
            [
                'user' => [
                    'username' => 'massimo',
                    'code' => 'massimo',
                    'email' => 'massimo@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Massimo',
                    'lastname' => 'Di Moia',
                ],
                'roles' => ['ROLE_EDITOR', 'ROLE_MODERATOR']
            ],
            [
                'user' => [
                    'username' => 'gabriella',
                    'code' => 'gabriella',
                    'email' => 'gabriella@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Gabriella',
                    'lastname' => 'Castagna',
                ],
                'roles' => ['ROLE_ADMIN', 'ROLE_EDITOR']
            ],
            [
                'user' => [
                    'username' => 'federico',
                    'code' => 'federico',
                    'email' => 'federico@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Federico',
                    'lastname' => 'Di Moia',
                ],
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'user' => [
                    'username' => 'alessandro',
                    'code' => 'alessandro',
                    'email' => 'alessandro@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Alessandro',
                    'lastname' => 'Di Moia',
                ],
                'roles' => ['ROLE_ADMIN', 'ROLE_SUPERADMIN']
            ],
            [
                'user' => [
                    'username' => 'gino',
                    'code' => 'gino',
                    'email' => 'gino@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Gino',
                    'lastname' => 'Di Moia',
                ],
                'roles' => ['ROLE_ADMIN', 'ROLE_SUPERADMIN']
            ],
            [
                'user' => [
                    'username' => 'gianna',
                    'code' => 'gianna',
                    'email' => 'gianna@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Gianna',
                    'lastname' => 'Ciammaichella',
                ],
                'roles' => ['ROLE_TECHNICIAN']
            ],
            [
                'user' => [
                    'username' => 'davide',
                    'code' => 'davide',
                    'email' => 'davide@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Davide',
                    'lastname' => 'Castagna',
                ]
            ],
            [
                'user' => [
                    'username' => 'simone',
                    'code' => 'simone',
                    'email' => 'simone@ipercollege.it',
                    'password' => '$2y$13$l2SmFZZpyNrc3sVn.k4ysO900I2fjMzeRkUldoU4DUsZIITevAQbi' // admin123
                ],
                'profile' => [
                    'firstname' => 'Simone',
                    'lastname' => 'Castagna',
                ]
            ],
        ];

    }

    public function getDependencies(): array
    {
        return [
            UserRoleFixtures::class,
            UserGroupFixtures::class,
        ];
    }
}