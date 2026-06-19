<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Type\MutationType;
use App\GraphQL\Type\QueryType;
use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;

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
