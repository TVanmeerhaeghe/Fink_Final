<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartenariatTest extends WebTestCase
{
    public function testIfDemandePartenariatIsWorking(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $user = $entityManager->find(User::class, 1);
        $client->loginUser($user);

        $crawler = $client->request('GET', $urlGenerator->generate('contact.partenariat'));
        $form = $crawler->filter("form[name=demande_salon]")->form([
            'demande_salon[nom]' => "Tatoo",
            'demande_salon[Adresse]' => "Rue du Test",
            'demande_salon[Ville]' => "Test",
            'demande_salon[telephone]' => 1111,
            'demande_salon[Siret]' => 1111,
            'demande_salon[Description]' => 'Description',
            'demande_salon[email]' => "Test@test.fr",
            'demande_salon[style]' => 'Old School',
            'demande_salon[imageFile][file]' => "test.jpg"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('div.alert-success', 'Votre demande a été envoyée avec succès ! Nos équipes reviendront vers vous une fois les vérifications faites');
    }
}
