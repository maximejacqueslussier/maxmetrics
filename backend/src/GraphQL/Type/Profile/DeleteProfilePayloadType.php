<?php

declare(strict_types=1);

namespace App\GraphQL\Type\Profile;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class DeleteProfilePayloadType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'DeleteProfilePayload',
            'fields' => [
                'deletedProfileId' => [
                    'type' => Type::nonNull(Type::id()),
                ],
            ],
        ]);
    }
}
