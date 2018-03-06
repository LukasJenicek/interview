<?php
namespace App\Infrastructure\Watch;

use App\Domain\Watch\Watch;
use App\Infrastructure\Persistence\Cache\CacheStorage;
use App\Infrastructure\Persistence\Database\MysqlWatchNotFoundException;
use App\Infrastructure\Persistence\Database\MysqlWatchRepository;


/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class WatchRepository implements \App\Domain\Watch\WatchRepository
{

	/**
	 * @var MysqlWatchRepository
	 */
	private $mysqlWatchRepository;
	/**
	 * @var CacheStorage
	 */
	private $cacheStorage;

	public function __construct(MysqlWatchRepository $mysqlWatchRepository, CacheStorage $cacheStorage)
	{
		$this->mysqlWatchRepository = $mysqlWatchRepository;
		$this->cacheStorage = $cacheStorage;
	}

	public function getWatchById(int $id): ?Watch
	{
		try {
			$watchDTO = $this->mysqlWatchRepository->getWatchById($id);
		} catch (MysqlWatchNotFoundException $e) {
			return null;
		}

		return new Watch(
			$watchDTO->id,
			$watchDTO->title,
			$watchDTO->price,
			$watchDTO->description
		);
	}

}
