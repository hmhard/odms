<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixture extends Fixture
{
    private $userPasswordHasherInterface;
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface) {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();
                $user = new User();
        $user->setEmail(chr(rand(90,116))."@gmail.com");
        $user->setFirstName($faker->name);
        $user->setMiddleName($faker->name);
        $user->setLastName($faker->name);
 
        $user->setSex("M");
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,"1234"));
        

        $manager->persist($user);

        $manager->flush();
    }
}
