<?php

namespace App\Tests\Unit;

use Library\Http\Request\Uniformity\UniformedRequest;
use Library\Http\Request\Uniformity\UniformRequestResolverFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResolvedRequestTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        static::createClient();
    }

    public function test_valid_resolved_request()
    {
        $validRequest = [
            'baseUrl' => '33.33.33.10',
            'route' => '/route/to/resource',
            'internalType' => 'view',
            'name' => 'name',
            'data' => [
                'some_data' => [],
            ],
            'method' => 'get',
        ];

        $uniformedRequest = UniformRequestResolverFactory::create($validRequest);

        static::assertInstanceOf(UniformedRequest::class, $uniformedRequest);
    }
}