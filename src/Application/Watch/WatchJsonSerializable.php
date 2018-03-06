<?php

namespace App\Application\Watch;

use App\Domain\Watch\Watch;
use App\Infrastructure\Persistence\Cache\JsonSerializable;
use App\Infrastructure\Persistence\Cache\Serializable;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class WatchJsonSerializable implements Serializable
{

	/**
	 * @var Watch
	 */
	private $watch;

	public function __construct(Watch $watch)
	{
		$this->watch = $watch;
	}

	public function getTarget(): string
	{
		return Watch::class;
	}

	public function serialize()
	{
		return [
			"id" => $this->watch->getId(),
			"title" => $this->watch->getTitle(),
			"price" => $this->watch->getPrice(),
			"description" => $this->watch->getDescription()
		];
	}

}
