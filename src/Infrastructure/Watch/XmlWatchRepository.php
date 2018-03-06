<?php

namespace App\Infrastructure\Watch;

use App\Domain\Watch\Watch;
use App\Domain\Watch\WatchRepository;
use App\Infrastructure\Persistence\Xml\XmlWatchLoader;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class XmlWatchRepository implements WatchRepository
{

	/**
	 * @var XmlWatchLoader
	 */
	private $xmlWatchLoader;

	public function __construct(XmlWatchLoader $xmlWatchLoader)
	{
		$this->xmlWatchLoader = $xmlWatchLoader;
	}

	public function getWatchById(int $id): ?Watch
	{
		$data = $this->xmlWatchLoader->loadByIdFromXml("watch-{$id}");

		if ($data === null) {
			return $data;
		}

		return new Watch(
			$data["id"],
			$data["title"],
			$data["price"],
			$data["desc"]
		);
	}

}
