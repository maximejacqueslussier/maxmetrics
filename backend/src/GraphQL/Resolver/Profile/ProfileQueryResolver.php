<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver\Profile;

use App\Application\Profile\ListProfiles\ListProfiles;
use App\Application\Profile\ListProfiles\ProfilesListQuery;
use App\Domain\Profile\Profile;
use Symfony\Contracts\Translation\TranslatorInterface;

use function array_key_exists;
use function array_map;
use function array_pop;
use function count;
use function base64_encode;
use function base64_decode;
use function is_array;
use function is_string;
use function json_encode;
use function json_decode;

final readonly class ProfileQueryResolver
{
    public function __construct(
        private ListProfiles $listProfiles,
        private TranslatorInterface $translator,
    ) {
    }

    public function listProfiles($root, array $args): iterable
    {
        $query = new ProfilesListQuery($this->translator);
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

        $profiles = $this->listProfiles->execute($query);

        $edges = array_map(function (Profile $profile) {
            $cursor = base64_encode(
                json_encode([
                    'id' => $profile->getId(),
                ], JSON_THROW_ON_ERROR),
            );

            return [
                'node' => $profile,
                'cursor' => $cursor,
            ];
        }, $profiles);

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

        $pageInfo = [
            'hasPreviousPage' => $hasPreviousPage,
            'hasNextPage' => $hasNextPage,
            'startCursor' => $startCursor,
            'endCursor' => $endCursor,
        ];

        return [
            'edges' => $edges,
            'pageInfo' => $pageInfo,
        ];
    }
}
