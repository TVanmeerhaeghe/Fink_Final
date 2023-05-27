<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\Salon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalonFuncTest extends WebTestCase
{
    public function testIfListingSalonIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 1);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, $urlGenerator->generate('salon.list'));

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('salon.list');
    }

    public function testIfUpdateAnSalonIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 1);
        $salon = $entityManager->getRepository(Salon::class)->findOneBy([
            'Proprietaire' => $user
        ]);

        $client->loginUser($user);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('salon.edit', ['id' => $salon->getId()])
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=salon]')->form([
            'salon[Nom]' => "Tatoo",
            'salon[Email]' => "tatoo@email.fr"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('div.alert-success', 'Votre salon a été modifié avec succès !');

        $this->assertRouteSame('salon.list');
    }
}
