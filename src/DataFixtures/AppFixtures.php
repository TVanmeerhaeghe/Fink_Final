<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;


    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) { 
            $article = new Article();
            $article->setTitre($this->faker->sentence($nbWords = 5, $variableNbWords = true))
            ->setSujet($this->faker->sentence($nbWords = 5, $variableNbWords = true))
            ->setContenu($this->faker->paragraph($nbSentences = 20));

            $manager->persist($article);
        }

        for ($i=0; $i < 20 ; $i++) { 
            $user = new User();
            $user->setEmail($this->faker->email())
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('password')
            ->setNom($this->faker->firstName())
            ->setPrenom($this->faker->lastName())
            ->setTelephone($this->faker->numberBetween(100000000, 999999999));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
