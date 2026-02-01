<?php

declare(strict_types=1);

namespace App\Controller;

use App\GraphQL\Request\BadRequestGraphQLException;
use App\GraphQL\Request\RequestParser;
use App\GraphQL\Execution\Executor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

final class GraphQLController extends AbstractController
{
    public function __construct(
        private readonly RequestParser $requestParser,
        private readonly Executor $graphQLExecutor,
        private readonly KernelInterface $kernel,
    ) {
    }

    #[Route('/graphql', name: 'graphql', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        try {
            $graphQLRequest = $this->requestParser->parse($request);
        } catch (BadRequestGraphQLException $e) {
            $message = $this->kernel->isDebug() ? $e->getMessage() : 'Invalid GraphQL request';

            return $this->json([
                'errors' => [
                    [
                        'message' => $message,
                        'extensions' => [
                            'code' => 'BAD_REQUEST',
                        ],
                    ],
                ],
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $executionResult = $this->graphQLExecutor->executeQuery($graphQLRequest);

        return $this->json($executionResult->toArray());
    }
}
