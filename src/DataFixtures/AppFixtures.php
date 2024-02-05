<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\GitLink;
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
                ->setRoles(['ROLE_USER']);
            $users[] = $user;
            $manager->persist($user);
        }

        //git-links
        $links = [];
        for ($li = 0; $li < 40; $li++) {
            $gitLink = new GitLink();
            // Générer un URL GitHub
            $gitUrlGenerated = 'https://github.com/' . $this->faker->regexify('[a-zA-Z0-9]{5,10}');
            $gitLink->setUrl($gitUrlGenerated)
                //->setReport()
                ->setUser($users[mt_rand(0, count($users) - 1)]);
            $links[] = $gitLink;
            $manager->persist($gitLink);
        }
        $manager->flush();
    }
}
