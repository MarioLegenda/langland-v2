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

    protected function setup()
    {
        $this->client = static::createClient();

        $this->locator = $this->client->getContainer();
    }
}