<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\User;

use App\Application\User\ListUsers\ListUsers;
use App\Application\User\ListUsers\UsersListQuery;
use Symfony\Contracts\Translation\TranslatorInterface;

use function array_key_exists;
use function array_map;
use function array_pop;
use function base64_decode;
use function base64_encode;
use function count;
use function end;
use function is_array;
use function is_string;
use function json_decode;
use function json_encode;

final readonly class UserQueryResolver
{
    public function __construct(
        private ListUsers $listUsers,
        private TranslatorInterface $translator,
    ) {
    }

    public function listUsers(mixed $root, array $args): iterable
    {
        $query = new UsersListQuery($this->translator);
        $hasPreviousPage = false;
        $hasNextPage = false;

        if (
            array_key_exists('filter', $args)
            && is_array($args['filter'])
            && array_key_exists('ids', $args['filter'])
        ) {
            $query->setIds($args['filter']['ids']);
        }

        if (array_key_exists('orderBy', $args) && is_array($args['orderBy'])) {
            $query->setSorts($args['orderBy']);
        }

        if (array_key_exists('first', $args)) {
            $query->setFirstIds($args['first']);
            $query->setLimit($args['first'] + 1);
        }

        if (array_key_exists('after', $args) && is_string($args['after'])) {
            $decoded = json_decode(
                base64_decode($args['after']),
                true,
                512,
                JSON_THROW_ON_ERROR,
            );

            if (is_array($decoded) && array_key_exists('id', $decoded)) {
                $query->setAfterId($decoded['id']);
            }
        }

        $users = $this->listUsers->execute($query);

        $edges = array_map(function (object $user) {
            $cursor = base64_encode(
                json_encode([
                    'id' => $user->getId(),
                ], JSON_THROW_ON_ERROR),
            );

            return [
                'node' => $user,
                'cursor' => $cursor,
            ];
        }, $users);

        $startCursor = null;
        $endCursor = null;

        if (count($edges) > 0) {
            $startCursor = $edges[0]['cursor'];
            $endCursor = end($edges)['cursor'];

            if (array_key_exists('after', $args) && is_string($args['after'])) {
                $hasPreviousPage = true;
            }

            if (
                array_key_exists('first', $args)
                && count($edges) > $args['first']
            ) {
                $hasNextPage = true;
                array_pop($edges);
            }
        }

        return [
            'edges' => $edges,
            'pageInfo' => [
                'hasPreviousPage' => $hasPreviousPage,
                'hasNextPage' => $hasNextPage,
                'startCursor' => $startCursor,
                'endCursor' => $endCursor,
            ],
        ];
    }
}
