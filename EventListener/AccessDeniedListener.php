<?php

/*
 * This file is part of the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\RestBundle\EventListener;

use FOS\RestBundle\FOSRestBundle;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * This listener handles ensures that for specific formats AccessDeniedExceptions
 * will return a 403 regardless of how the firewall is configured.
 *
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
 *
 * @internal
 */
class AccessDeniedListener implements EventSubscriberInterface
{
    private $formats;
    private $challenge;

    /**
     * @param array $formats An array with keys corresponding to request formats or content types
     *                       that must be processed by this listener
     */
    public function __construct(array $formats, ?string $challenge)
    {
        $this->formats = $formats;
        $this->challenge = $challenge;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        static $handling;

        if (true === $handling) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->attributes->get(FOSRestBundle::ZONE_ATTRIBUTE, true)) {
            return;
        }

        if (empty($this->formats[$request->getRequestFormat()]) && empty($this->formats[$request->getContentType()])) {
            return;
        }

        $handling = true;

        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedException) {
            $exception = new AccessDeniedHttpException('You do not have the necessary permissions');
        } elseif ($exception instanceof AuthenticationException) {
            if ($this->challenge) {
                $exception = new UnauthorizedHttpException($this->challenge, 'You are not authenticated');
            } else {
                $exception = new HttpException(401, 'You are not authenticated');
            }
        }

        $event->setThrowable($exception);

        $handling = false;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 5],
        ];
    }
}
