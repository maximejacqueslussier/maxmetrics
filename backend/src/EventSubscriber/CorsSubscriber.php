<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class CorsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private string $corsAllowOrigin,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getMethod() !== Request::METHOD_OPTIONS) {
            return;
        }

        if ($request->getPathInfo() !== '/graphql') {
            return;
        }

        $response = new Response('', Response::HTTP_NO_CONTENT);
        $this->addCorsHeaders($response);
        $event->setResponse($response);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getPathInfo() !== '/graphql') {
            return;
        }

        $this->addCorsHeaders($event->getResponse());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 300],
            KernelEvents::RESPONSE => ['onKernelResponse', -300],
        ];
    }

    private function addCorsHeaders(Response $response): void
    {
        $response->headers->set('Access-Control-Allow-Origin', $this->corsAllowOrigin);
        $response->headers->set('Access-Control-Allow-Methods', 'POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Max-Age', '600');

        $vary = $response->getVary();
        if (!in_array('Origin', $vary, true)) {
            $vary[] = 'Origin';
            $response->setVary($vary);
        }
    }
}
