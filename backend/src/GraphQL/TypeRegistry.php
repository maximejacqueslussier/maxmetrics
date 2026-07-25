<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Input\Account\UpdateEmailInputType;
use App\GraphQL\Input\Account\UpdatePasswordInputType;
use App\GraphQL\Input\Account\UpdateProfileInputType;
use App\GraphQL\Input\Account\UpdateUsernameInputType;
use App\GraphQL\Input\Authentication\LoginInputType;
use App\GraphQL\Input\User\CreateUserInputType;
use App\GraphQL\Input\User\UpdateUserInputType;
use App\GraphQL\Input\User\UserFilterInputType;
use App\GraphQL\Input\User\UserOrderByInputType;
use App\GraphQL\Type\PageInfoType;
use App\GraphQL\Type\Account\UpdateEmailPayloadType;
use App\GraphQL\Type\Account\UpdatePasswordPayloadType;
use App\GraphQL\Type\Account\UpdateProfilePayloadType;
use App\GraphQL\Type\Account\UpdateUsernamePayloadType;
use App\GraphQL\Type\Authentication\LoginPayloadType;
use App\GraphQL\Type\Authentication\RefreshTokenPayloadType;
use App\GraphQL\Type\Authentication\LogoutPayloadType;
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
        return $this->types['LoginInput'] ??= new LoginInputType();
    }

    public function refreshTokenPayload(): RefreshTokenPayloadType
    {
        return $this->types['RefreshTokenPayload'] ??= new RefreshTokenPayloadType($this);
    }

    public function logoutPayload(): LogoutPayloadType
    {
        return $this->types['LogoutPayload'] ??= new LogoutPayloadType();
    }

    public function updateUsernamePayload(): UpdateUsernamePayloadType
    {
        return $this->types['UpdateUsernamePayload'] ??= new UpdateUsernamePayloadType($this);
    }

    public function updateUsernameInput(): UpdateUsernameInputType
    {
        return $this->types['UpdateUsernameInput'] ??= new UpdateUsernameInputType();
    }

    public function updateEmailPayload(): UpdateEmailPayloadType
    {
        return $this->types['UpdateEmailPayload'] ??= new UpdateEmailPayloadType($this);
    }

    public function updateEmailInput(): UpdateEmailInputType
    {
        return $this->types['UpdateEmailInput'] ??= new UpdateEmailInputType();
    }

    public function updatePasswordPayload(): UpdatePasswordPayloadType
    {
        return $this->types['UpdatePasswordPayload'] ??= new UpdatePasswordPayloadType();
    }

    public function updatePasswordInput(): UpdatePasswordInputType
    {
        return $this->types['UpdatePasswordInput'] ??= new UpdatePasswordInputType();
    }

    public function updateProfilePayload(): UpdateProfilePayloadType
    {
        return $this->types['UpdateProfilePayload'] ??= new UpdateProfilePayloadType($this);
    }

    public function updateProfileInput(): UpdateProfileInputType
    {
        return $this->types['UpdateProfileInput'] ??= new UpdateProfileInputType($this);
    }
}
