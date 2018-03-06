<?php

namespace App\Application\Watch;

use App\Domain\Watch\Watch;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class WatchAssembler
{

	public function toDTO(Watch $watch): WatchDTO
	{
		return new WatchDTO(
			$watch->getId(),
			$watch->getTitle(),
			$watch->getPrice(),
			$watch->getDescription()
		);
	}

}
