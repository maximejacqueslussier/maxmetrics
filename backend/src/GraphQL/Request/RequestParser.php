<?php

declare(strict_types=1);

namespace App\GraphQL\Request;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Contracts\Translation\TranslatorInterface;

use function is_array;
use function json_decode;

final readonly class RequestParser
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * Parse the Http Request body to extract query and variables to create a specific GraphQL Request object.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\GraphQL\Request\RequestInterface
     */
    public function parse(HttpRequest $request): RequestInterface
    {
        $input = json_decode(
            $request->getContent(),
            true,
            JSON_THROW_ON_ERROR,
        );

        $variables = $input['variables'] ?? null;

        if ($variables !== null && !is_array($variables)) {
            throw new BadRequestGraphQLException(
                $this->translator->trans(
                    'app.graphql.request.requestParser.badRequestGraphQLException',
                    ['{{ object }}', 'variables'],
                )
            );
        }

        return new Request(
            $input['query'] ?? '',
            $variables,
            $input['operationName'] ?? null,
        );
    }
}
