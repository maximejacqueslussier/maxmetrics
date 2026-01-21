<?php

declare(strict_types=1);

namespace App\Controller;

use App\GraphQL\Schema;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GraphQL\Error\DebugFlag;
use GraphQL\Error\Error;
use GraphQL\Error\FormattedError;
use GraphQL\GraphQL;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

use function array_key_exists;
use function count;
use function json_decode;

final class GraphQLController extends AbstractController
{
    public function __construct(
        private readonly Schema $schema,
        private readonly TranslatorInterface $translator,
        private readonly KernelInterface $kernel,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/graphql', name: 'graphql', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $response = new JsonResponse();

        try {
            $input = json_decode(
                $request->getContent(),
                true,
                JSON_THROW_ON_ERROR
            );

            $query = $input['query'] ?? '';
            $variables = $input['variables'] ?? null;
            $result = GraphQL::executeQuery(
                ($this->schema)(),
                $query,
                null,
                null,
                $variables,
            );

            $result->setErrorFormatter(function (Error $error) {
                $previousException = $error->getPrevious();

                if ($previousException instanceof ValidationFailedException) {
                    $fieldErrors = [];

                    foreach ($previousException->getViolations() as $violation) {
                        $fieldErrors[$violation->getPropertyPath()] = $this->translator->trans(
                            $violation->getMessage()
                        );
                    }

                    return [
                        'message' => $previousException->getValue(),
                        'path' => $error->getPath(),
                        'extensions' => [
                            'code' => 'VALIDATION_ERROR',
                            'fields' => $fieldErrors,
                        ],
                    ];
                }

                $debugFlags = $this->kernel->isDebug()
                    ? DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE
                    : DebugFlag::NONE;

                return FormattedError::createFromException($error, $debugFlags);
            });

            if (count($result->errors) === 0) {
                $this->entityManager->flush();
            }

            $response = $this->json($result->toArray());
        } catch (Throwable $t) {
            $message = $this->kernel->isDebug() ? $t->getMessage() : 'Internal server error';
            $response = $this->json([
                'errors' => [
                    'message' => $message,
                    'locations' => [
                        'line' => $t->getLine(),
                        'code' => $t->getCode(),
                    ],
                ],
            ]);
        }

        return $response;
    }
}
