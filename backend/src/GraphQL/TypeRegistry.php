<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Input\Authentication\LoginInputType;
use App\GraphQL\Input\User\CreateUserInputType;
use App\GraphQL\Input\User\UpdateUserInputType;
use App\GraphQL\Input\User\UserFilterInputType;
use App\GraphQL\Input\User\UserOrderByInputType;
use App\GraphQL\Type\PageInfoType;
use App\GraphQL\Type\Authentication\LoginPayloadType;
use App\GraphQL\Type\Authentication\RefreshTokenPayloadType;
use App\GraphQL\Type\Definition\DateTimeType;
use App\GraphQL\Type\Definition\OrderByDirectionType;
use App\GraphQL\Type\User\CreateUserPayloadType;
use App\GraphQL\Type\User\DeleteUserPayloadType;
use App\GraphQL\Type\User\UpdateUserPayloadType;
use App\GraphQL\Type\User\UserConnectionType;
use App\GraphQL\Type\User\UserEdgeType;
use App\GraphQL\Type\User\UserOrderByFieldType;
use App\GraphQL\Type\User\UserRoleType;
use App\GraphQL\Type\User\UserType;

final class TypeRegistry
{
    private array $types = [];

    public function createUserInput(): CreateUserInputType
    {
        return $this->types['CreateUserInput'] ??= new CreateUserInputType($this);
    }

    public function updateUserInput(): UpdateUserInputType
    {
        return $this->types['UpdateUserInput'] ??= new UpdateUserInputType($this);
    }

    public function userFilterInput(): UserFilterInputType
    {
        return $this->types['UserFilterInput'] ??= new UserFilterInputType();
    }

    public function userOrderByInput(): UserOrderByInputType
    {
        return $this->types['UserOrderByInput'] ??= new UserOrderByInputType($this);
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

    public function createUserPayload(): CreateUserPayloadType
    {
        return $this->types['CreateUserPayload'] ??= new CreateUserPayloadType($this);
    }

    public function updateUserPayload(): UpdateUserPayloadType
    {
        return $this->types['UpdateUserPayload'] ??= new UpdateUserPayloadType($this);
    }

    public function deleteUserPayload(): DeleteUserPayloadType
    {
        return $this->types['DeleteUserPayload'] ??= new DeleteUserPayloadType();
    }

    public function userConnection(): UserConnectionType
    {
        return $this->types['UserConnection'] ??= new UserConnectionType($this);
    }

    public function userEdge(): UserEdgeType
    {
        return $this->types['UserEdge'] ??= new UserEdgeType($this);
    }

    public function userOrderByField(): UserOrderByFieldType
    {
        return $this->types['UserOrderByField'] ??= new UserOrderByFieldType();
    }

    public function userRole(): UserRoleType
    {
        return $this->types['UserRole'] ??= new UserRoleType();
    }

    public function user(): UserType
    {
        return $this->types['User'] ??= new UserType($this);
    }

    public function loginPayload(): LoginPayloadType
    {
        return $this->types['LoginPayload'] ??= new LoginPayloadType($this);
    }

    public function loginInput(): LoginInputType
    {
        return $this->types['loginInput'] ??= new LoginInputType();
    }

    public function refreshTokenPayload(): RefreshTokenPayloadType
    {
        return $this->types['refreshTokenPayload'] ??= new RefreshTokenPayloadType($this);
    }
}
