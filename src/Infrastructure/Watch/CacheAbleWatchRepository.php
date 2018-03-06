<?php

namespace App\Infrastructure\Watch;

use App\Application\Watch\WatchJsonSerializable;
use App\Domain\Watch\Watch;
use App\Domain\Watch\WatchRepository;
use App\Infrastructure\Persistence\Cache\CacheStorage;
use App\Infrastructure\Serializer\JsonToDomainObjectSerializer;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class CacheAbleWatchRepository implements WatchRepository
{

	/**
	 * @var WatchRepository
	 */
	private $watchRepository;

	/**
	 * @var CacheStorage
	 */
	private $cacheStorage;

	/**
	 * @var JsonToDomainObjectSerializer
	 */
	private $serializer;

	public function __construct(
		WatchRepository $watchRepository,
		CacheStorage $cacheStorage,
		JsonToDomainObjectSerializer $serializer
	)
	{
		$this->watchRepository = $watchRepository;
		$this->cacheStorage = $cacheStorage;
		$this->serializer = $serializer;
	}

	public function getWatchById(int $id): ?Watch
	{
		$cachingKey = sprintf("%s-%d", "watch", $id);

		if ($this->cacheStorage->isCached($cachingKey)) {
			$data = $this->cacheStorage->getResource($cachingKey);

			return $this->serializer->toDomainObject($data);
		}

		$watch = $this->watchRepository->getWatchById($id);

		if ($watch === null) {
			return null;
		}

		$this->cacheStorage->save($cachingKey, new WatchJsonSerializable($watch));

		return $watch;
	}

}
