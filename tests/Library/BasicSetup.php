<?php

namespace App\Tests\Library;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

class BasicSetup extends WebTestCase
{
    use FakerTrait;
    /**
     * @var Client $client
     */
    protected $client;
    /**
     * @var ContainerInterface $container
     */
    protected $locator;

    protected function setUp()
    {
        $this->client = static::createClient();

        $this->locator = $this->client->getContainer();

        exec('/var/www/vendor/bin/doctrine orm:schema-tool:drop --force');
        exec('/var/www/vendor/bin/doctrine orm:schema-tool:create');
        exec('/var/www/vendor/bin/doctrine orm:schema-tool:update --force');
    }
}