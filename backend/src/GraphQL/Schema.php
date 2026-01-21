<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Type\MutationType;
use App\GraphQL\Type\QueryType;
use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;

/**
 * This class encapsulate the GraphQLSchema class into a stateless, immutable and single-purpose service.
 */
final class Schema
{
    private GraphQLSchema $schema;

    public function __construct(
        QueryType $queryType,
        MutationType $mutationType,
    ) {
        $config = new SchemaConfig();
        $config
            ->setQuery($queryType)
            ->setMutation($mutationType);

        $this->schema = new GraphQLSchema($config);
    }

    public function __invoke(): GraphQLSchema
    {
        return $this->schema;
    }
}
