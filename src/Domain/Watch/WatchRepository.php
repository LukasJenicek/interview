<?php
namespace App\Domain\Watch;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
interface WatchRepository
{

	public function getWatchById(int $id): ?Watch;
}
