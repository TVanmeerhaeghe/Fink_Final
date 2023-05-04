<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Salon;
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
            ->setContenu($this->faker->paragraph($nbSentences = 20))
            ->setImage('images/article/knucle-tattoos-man.jpg');

            $manager->persist($article);
        }

        $users = [];

        $admin = new User();
        $admin->setTelephone($this->faker->numberBetween(100000000, 999999999))
            ->setNom('admin')
            ->setPrenom('admin')
            ->setEmail('admin@fink.fr')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPlainPassword('password');

        $users[] = $admin;
        $manager->persist($admin);

        for ($i=0; $i < 20 ; $i++) { 
            $user = new User();
            $user->setEmail($this->faker->email())
            ->setRoles($this->faker->randomElement([['ROLE_USER'], ['ROLE_USER', 'ROLE_TATOUEUR']]))
            ->setPlainPassword('password')
            ->setNom($this->faker->firstName())
            ->setPrenom($this->faker->lastName())
            ->setTelephone($this->faker->numberBetween(100000000, 999999999));

            $users[] = $user;
            $manager->persist($user);
        }


        for ($i=0; $i < 10 ; $i++) { 
            $salon = new Salon();
            $salon->setNom($this->faker->word())
            ->setAdresse($this->faker->streetAddress())
            ->setTelephone($this->faker->numberBetween(100000000, 999999999))
            ->setDescription($this->faker->paragraph($nbSentences = 20))
            ->setEmail($this->faker->email())
            ->setVille($this->faker->randomElement(['Lille', 'Marseille', 'Paris']))
            ->setSiret($this->faker->numberBetween(100000000, 999999999))
            ->setIsTrusted(true)
            ->setStyle($this->faker->randomElement([
                'Old School',
                'New School',
                'Blackwork',
                'Dotwork',
                'Tribal',
                'Realiste',
                'Aquarelle',
                'Neo-traditionnel',
                'Geometrique',
                'Trash Polka',
                'Maori',
                'Japonais',
                'Calligraphie',
                'Minimaliste',
                'Symbole',
                'Lettrage',
                'Ornemental',
                'Bio-mecanique',
                'Cartoon',
                'Portrait',
                'Graffiti',
                'Couleur',
                'Gravure',
                'Religieux',
                'Fantaisie',
                'Abstrait'
            ]));
            // Filtrer les utilisateurs ayant les rôles spécifiques
            $usersWithRole = array_filter($users, function($user) {
                return in_array('ROLE_USER', $user->getRoles()) && in_array('ROLE_TATOUEUR', $user->getRoles());
            });

            // Choisir un propriétaire aléatoire parmi les utilisateurs filtrés
            $proprietaire = $usersWithRole[array_rand($usersWithRole)];
            $salon->setProprietaire($proprietaire)
            ->setImage('images/salon/tattoo-shop-sign.jpg');
        
            $manager->persist($salon);
        }

        $manager->flush();
    }
}
