<?php

namespace App\Domain\Watch;

use Exception;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class Watch
{

	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var float
	 */
	private $price;

	/**
	 * @var string
	 */
	private $description;

	public function __construct(int $id, string $title, float $price, string $description)
	{
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;

		$this->setPrice($price);
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @throws Exception
	 */
	private function setPrice(float $price)
	{
		if ($price <= 0) {
			throw new Exception("Price must be positive");
		}

		$this->price = $price;
	}

}
