<?php

namespace App\Application\Watch;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class WatchDTO implements \JsonSerializable
{

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var float
	 */
	public $price;

	/**
	 * @var string
	 */
	public $description;

	public function __construct(int $id, string $title, int $price, string $description)
	{
		$this->id = $id;
		$this->title = $title;
		$this->price = $price;
		$this->description = $description;
	}

	public function jsonSerialize()
	{
		return [
			"identification" => $this->id,
			"title" => $this->title,
			"price" => $this->price,
			"description" => $this->description
		];
	}


}
