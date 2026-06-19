<?php

declare(strict_types=1);

namespace App\GraphQL\Execution;

use App\GraphQL\Error\ErrorFormatterChain;
use App\GraphQL\Request\Request;
use App\GraphQL\Schema;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\Error;
use GraphQL\Executor\ExecutionResult;
use GraphQL\GraphQL;
use Symfony\Contracts\Translation\TranslatorInterface;

use function sprintf;

final readonly class Executor
{
    public function __construct(
        private Schema $schema,
        private ErrorFormatterChain $errorFormatterChain,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
    ) {
    }

    public function executeQuery(Request $request): ExecutionResult
    {
        try {
            $result = $this->entityManager->wrapInTransaction(function () use ($request) {
                $result = GraphQL::executeQuery(
                    ($this->schema)(),
                    $request->getQuery(),
                    null,
                    null,
                    $request->getVariables(),
                    $request->getOperationName(),
                );

                $result->setErrorFormatter([$this->errorFormatterChain, 'format']);

                if (count($result->errors) !== 0) {
                    throw new ExecutorException(
                        $result,
                        $this->translator->trans('app.graphql.execution.executor.executorException'),
                    );
                }

                return $result;
            });

            return $result;
        } catch (ExecutorException $e) {
            return $e->getResult();
        }
    }
}
