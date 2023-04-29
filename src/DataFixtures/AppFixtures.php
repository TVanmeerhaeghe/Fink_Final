<?php

namespace App\DataFixtures;

use Faker\Factory;
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
            ->setContenu($this->faker->paragraph());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
