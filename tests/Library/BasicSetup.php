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

        $conn->exec('TRUNCATE TABLE users');
        $conn->exec('TRUNCATE TABLE categories');
        $conn->exec('TRUNCATE TABLE images');
        $conn->exec('TRUNCATE TABLE languages');
        $conn->exec('TRUNCATE TABLE words');
        $conn->exec('TRUNCATE TABLE lessons');
        $conn->exec('TRUNCATE TABLE word_categories');
        $conn->exec('TRUNCATE TABLE word_translations');
        $conn->exec('TRUNCATE TABLE locales');
        $conn->exec('TRUNCATE TABLE users');
        $conn->exec('TRUNCATE TABLE lesson_data');
        $conn->exec('TRUNCATE TABLE basic_data_collector');
        $conn->exec('TRUNCATE TABLE learning_lessons');

        $conn->exec('SET FOREIGN_KEY_CHECKS=1');
    }
}