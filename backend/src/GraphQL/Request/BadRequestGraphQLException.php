<?php

declare(strict_types=1);

namespace App\GraphQL\Request;

use UnexpectedValueException;

final class BadRequestGraphQLException extends UnexpectedValueException
{
}
