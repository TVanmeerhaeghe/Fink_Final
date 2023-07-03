<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactTest extends WebTestCase
{
    public function testContactForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Formulaire de contact');

        $submitButton = $crawler->selectButton('Envoyer');
        $form = $submitButton->form();

        $form["contact[prenom]"] = "Téo";
        $form["contact[nom]"] = "Vanmee";
        $form["contact[email]"] = "tv@gmail.com";
        $form["contact[Sujet]"] = "Test";
        $form["contact[Message]"] = "Test";

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertSelectorTextContains('div.alert-success', 'Votre message a été envoyé avec succès !');

    }
}
