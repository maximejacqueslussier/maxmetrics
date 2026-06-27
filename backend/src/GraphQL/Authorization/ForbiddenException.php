<?php

declare(strict_types=1);

namespace App\GraphQL\Authorization;

use RuntimeException;

final class ForbiddenException extends RuntimeException
{
}
