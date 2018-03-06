<?php

namespace App\Infrastructure\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class ExceptionListener
{

	public function onKernelException(GetResponseForExceptionEvent $event)
	{
		$exception = $event->getException();

		$responseData = [
			"error" => [
				"code" => $exception->getStatusCode(),
				"message" => $exception->getMessage()
			]
		];

		$event->setResponse(new JsonResponse($responseData, $exception->getStatusCode()));
	}

}
