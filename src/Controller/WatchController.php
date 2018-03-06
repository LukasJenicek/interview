<?php
namespace App\Controller;

use App\Application\Watch\WatchService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class WatchController extends Controller
{

	/**
	 * @var WatchService
	 */
	private $watchService;

	public function __construct(WatchService $watchService)
	{
		$this->watchService = $watchService;
	}

	public function getByIdAction(Request $request, int $id): Response
	{
		if ($id < 0 || is_int($id) === false) {
			throw new BadRequestHttpException("ID must be positive whole number");
		}

		$watchDTO = $this->watchService->getWatch($id);

		if ($watchDTO === null) {
			throw new NotFoundHttpException("Watch with ID {$id} couldn't be find");
		}

		return new JsonResponse($watchDTO);
	}

}
