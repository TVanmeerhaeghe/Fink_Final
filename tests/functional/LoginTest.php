<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testIfLoginIsSuccesfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");
        $crawler = $client->request('GET', $urlGenerator->generate('security.login'));

        $form = $crawler->filter("form[name=login]")->form([
            "_username" => "admin@fink.fr",
            "_password" => "password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('home.index');
    }

    public function testIfLoginFailedWhenMailIsWrong(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get("router");
        $crawler = $client->request('GET', $urlGenerator->generate('security.login'));

        $form = $crawler->filter("form[name=login]")->form([
            "_username" => "adminfink.fr",
            "_password" => "password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        $this->assertRouteSame('security.login');

        $this->assertSelectorTextContains("div.alert-danger", "Identifiants invalides.");
    }
}
