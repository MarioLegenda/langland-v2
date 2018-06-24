<?php

namespace App\Tests\Library;

use Doctrine\ORM\EntityManagerInterface;
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

        /** @var EntityManagerInterface $em */
        $em = $this->locator->get('doctrine')->getManager();
        /** @var \PDO $conn */
        $conn = $em->getConnection();

        $conn->exec('SET FOREIGN_KEY_CHECKS=0');

        $conn->exec('TRUNCATE TABLE categories');
        $conn->exec('TRUNCATE TABLE images');
        $conn->exec('TRUNCATE TABLE languages');
        $conn->exec('TRUNCATE TABLE words');
        $conn->exec('TRUNCATE TABLE lessons');
        $conn->exec('TRUNCATE TABLE word_categories');
        $conn->exec('TRUNCATE TABLE word_translations');

        $conn->exec('SET FOREIGN_KEY_CHECKS=1');
/*
        exec('/usr/bin/php bin/console do:da:dr --force');
        exec('/usr/bin/php bin/console do:da:cr');
        exec('/usr/bin/php bin/console do:sc:up --force');*/
    }
}