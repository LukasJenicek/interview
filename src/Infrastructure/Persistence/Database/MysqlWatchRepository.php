<?php

namespace App\Infrastructure\Persistence\Database;

use App\Application\Watch\WatchDTO;
use App\Infrastructure\Persistence\Cache\CacheStorage;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class MysqlWatchRepository
{


	/**
	 * @throws MysqlWatchNotFoundException
	 */
	public function getWatchById(int $id): WatchDTO
	{
		$watch = array_filter($this->getResources(), function(array $watch) use ($id) {
			return $watch["id"] === $id;
		});

		$watch = reset($watch);

		if ($watch === false) {
			throw new MysqlWatchNotFoundException("Watch with id {$id} couldn't be find");
		}

		return new WatchDTO(
			$watch["id"],
			$watch["title"],
			$watch["price"],
			$watch["description"]
		);
	}

	private function getResources(): array
	{
		return [
			250 => [
				"id" => 250,
				"title" => "Watch with water fountain",
				"price" => 200,
				"description" => "Beautifully crafted timepiece for every gentleman."
			]
		];
	}

}
