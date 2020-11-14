<?php
declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    public function urlProvider()
    {
        yield ['/api/servers'];
    }

    public function testGetServers()
    {
        $client = static::createClient();
        $client->request('GET', '/api/servers');

        // Check response status and response header
        $this->assertResponseIsSuccessful();
        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type', 'application/json'
        ));

        // Check JSON response
        $this->assertStringContainsString(
            'servers',
            $client->getResponse()->getContent()
        );

        // Check no. of servers
        $jsonArr = json_decode($client->getResponse()->getContent(), true );
        $this->assertEquals(
            486,
            count($jsonArr['servers'])
        );
    }

    public function testPageNotFound()
    {
        $client = static::createClient();

        $client->request('GET', '/api/wrong_uri');

        // Check response status
        $this->assertTrue($client->getResponse()->isNotFound());
        $this->assertResponseStatusCodeSame(404);
    }
}
