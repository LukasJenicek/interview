<?php

namespace App\Infrastructure\Persistence\Cache;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
interface CacheStorage
{

	public function isCached(string $key): bool;

	public function getResource(string $key): ?array;

	public function save(string $key, Serializable $serializable): bool;

}
