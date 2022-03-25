<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\Role;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    const NUMBER = 15;

    public function __construct(private UserService $userService)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('PAXANDDOS');
        $user->setEmail('pashalitovka@gmail.com');
        $user->setRoles([Role::Admin->value, Role::User->value]);
        $user->setPassword($this->userService->hashPassword($user, '123456789'));
        $manager->persist($user);
        $this->addReference("user_0", $user);

        $user = new User();
        $user->setName('Luna');
        $user->setEmail('lunadeepblue@gmail.com');
        $user->setRoles([Role::User->value]);
        $user->setPassword($this->userService->hashPassword($user, '123456789'));
        $manager->persist($user);
        $this->addReference("user_1", $user);

        $generator = Factory::create();
        for ($i = 2; $i <= self::NUMBER; $i++) {
            $user = new User();
            $user->setName($generator->name);
            $user->setEmail($generator->email);
            $user->setRoles([Role::User->value]);
            $user->setPassword($this->userService->hashPassword($user, $generator->password(8)));
            $manager->persist($user);

            $this->addReference("user_$i", $user);
        }

        $manager->flush();
    }
}
