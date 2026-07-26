<?php

declare(strict_types=1);

namespace App\Tests\GraphQL;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function json_decode;
use function json_encode;

abstract class GraphQLTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        static::ensureKernelShutdown();

        $this->client = static::createClient();
    }

    protected function graphql(
        string $query,
        array $variables = [],
        ?string $operationName = null,
        ?string $accessToken = null,
    ): array {
        $server = [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ];

        if ($accessToken !== null) {
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . $accessToken;
        }

        $this->client->request(
            'POST',
            '/graphql',
            [],
            [],
            $server,
            json_encode([
                'query' => $query,
                'variables' => $variables,
                'operationName' => $operationName,
            ], JSON_THROW_ON_ERROR),
        );

        return json_decode(
            $this->client->getResponse()->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
    }
}
