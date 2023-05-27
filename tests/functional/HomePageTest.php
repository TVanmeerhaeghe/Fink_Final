<?php

namespace App\Tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    public function testIfHomePageHaveTheGoodElement(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $salonAndArticle = $crawler->filter('.last-salon-item.box');
        $this->assertEquals(6, count($salonAndArticle));

        $carousel = $crawler->filter('.carousel-image');
        $this->assertEquals(3, count($carousel));

        $this->assertSelectorTextContains('h1', 'Trouve le tatoueur de tes reves en 3 clics :');
    }
}
