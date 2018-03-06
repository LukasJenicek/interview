<?php

namespace App\Application\Watch;

use App\Domain\Watch\Watch;
use App\Domain\Watch\WatchRepository;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class WatchService
{

	/**
	 * @var WatchRepository
	 */
	private $watchRepository;

	/**
	 * @var WatchAssembler
	 */
	private $watchAssembler;

	public function __construct(WatchRepository $watchRepository, WatchAssembler $watchAssembler)
	{
		$this->watchRepository = $watchRepository;
		$this->watchAssembler = $watchAssembler;
	}

	public function getWatch(int $id): ?WatchDTO
	{
		$watch = $this->watchRepository->getWatchById($id);

		if ($watch === null) {
			return null;
		}

		return $this->watchAssembler->toDTO($watch);
	}

}
