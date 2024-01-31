<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;
    private \Faker\Generator $faker;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        for ($u = 0; $u < 10; $u++) {
            $user = new User();

            $hashedPassword = $this->hasher->hashPassword(
                //implementer PasswordAuthenticatedUserInterface dans entité User avant
                $user,
                'password'
            );

            $user->setUsername($this->faker->name())
                ->setEmail($this->faker->email())
                ->setPassword($hashedPassword)
                ->setRoles(['ROLE_USER'])
                ->setLinkHub('https://github.com/exemple/');
            $users[] = $user;
            $manager->persist($user);



            //$users[] = $user;

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
