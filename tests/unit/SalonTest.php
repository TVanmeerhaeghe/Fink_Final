<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\Entity\Salon;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SalonTest extends KernelTestCase
{
    public function getEntity() : Salon
    {
        $salon = new Salon();
        $salon->setNom('Tatouage')
            ->setAdresse('1 rue de Lille')
            ->setTelephone(1111111)
            ->setDescription('Description')
            ->setEmail('email@email.fr')
            ->setVille('Lille')
            ->setSiret(111111)
            ->setIsTrusted(true)
            ->setStyle('Old School')
            ->setProprietaire(null)
            ->setImageName('tattoo-shop-sign.jpg');
    
        return $salon;
    }

    public function testIfEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $salon = $this->getEntity();
        $user = static::getContainer()->get('doctrine.orm.entity_manager')->find(User::class, 1);
        $salon->setProprietaire($user);

        $errors = $container->get('validator')->validate($salon);

        $this->assertCount(0, $errors);
    }

    public function testInvalidEmail(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $salon = $this->getEntity();
        $salon->setEmail('Jenesuispasunmail');

        $errors = $container->get('validator')->validate($salon);

        //Deux erreurs car le mail ne correspond pas et je ne définis pas de propriétaire
        $this->assertCount(2, $errors);
    }
}
