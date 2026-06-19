<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Input\Profile\CreateProfileInputType;
use App\GraphQL\Input\Profile\UpdateProfileInputType;
use App\GraphQL\Input\Profile\ProfileFilterInputType;
use App\GraphQL\Input\Profile\ProfileOrderByInputType;
use App\GraphQL\Type\PageInfoType;
use App\GraphQL\Type\Definition\DateTimeType;
use App\GraphQL\Type\Definition\OrderByDirectionType;
use App\GraphQL\Type\Profile\CreateProfilePayloadType;
use App\GraphQL\Type\Profile\DeleteProfilePayloadType;
use App\GraphQL\Type\Profile\UpdateProfilePayloadType;
use App\GraphQL\Type\Profile\ProfileConnectionType;
use App\GraphQL\Type\Profile\ProfileEdgeType;
use App\GraphQL\Type\Profile\ProfileOrderByFieldType;
use App\GraphQL\Type\Profile\ProfileType;

final class TypeRegistry
{
    private array $types = [];

    public function createProfileInput(): CreateProfileInputType
    {
        return $this->types['CreateProfileInput'] ??= new CreateProfileInputType();
    }

    public function updateProfileInput(): UpdateProfileInputType
    {
        return $this->types['UpdateProfileInput'] ??= new UpdateProfileInputType();
    }

    public function profileFilterInput(): ProfileFilterInputType
    {
        return $this->types['ProfileFilterInput'] ??= new ProfileFilterInputType();
    }

    public function profileOrderByInput(): ProfileOrderByInputType
    {
        return $this->types['ProfileOrderByInput'] ??= new ProfileOrderByInputType($this);
    }

    public function pageInfo(): PageInfoType
    {
        return $this->types['PageInfo'] ??= new PageInfoType();
    }

    public function dateTime(): DateTimeType
    {
        return $this->types['DateTime'] ??= new DateTimeType();
    }

    public function orderByDirection(): OrderByDirectionType
    {
        return $this->types['OrderByDirection'] ??= new OrderByDirectionType();
    }

    public function createProfilePayload(): CreateProfilePayloadType
    {
        return $this->types['CreateProfilePayload'] ??= new CreateProfilePayloadType($this);
    }

    public function deleteProfilePayload(): DeleteProfilePayloadType
    {
        return $this->types['DeleteProfilePayload'] ??= new DeleteProfilePayloadType();
    }

    public function updateProfilePayload(): UpdateProfilePayloadType
    {
        return $this->types['UpdateProfilePayload'] ??= new UpdateProfilePayloadType($this);
    }

    public function profileConnection(): ProfileConnectionType
    {
        return $this->types['ProfileConnection'] ??= new ProfileConnectionType($this);
    }

    public function profileEdge(): ProfileEdgeType
    {
        return $this->types['ProfileEdge'] ??= new ProfileEdgeType($this);
    }

    public function profileOrderByField(): ProfileOrderByFieldType
    {
        return $this->types['ProfileOrderByField'] ??= new ProfileOrderByFieldType();
    }

    public function profile(): ProfileType
    {
        return $this->types['Profile'] ??= new ProfileType($this);
    }
}
