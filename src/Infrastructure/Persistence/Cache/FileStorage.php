<?php

namespace App\Infrastructure\Persistence\Cache;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class FileStorage implements CacheStorage
{

	/**
	 * @var string
	 */
	private $cacheTarget;

	/**
	 * @var array
	 */
	private $resources;

	public function __construct(string $cacheTarget)
	{
		$this->cacheTarget = $cacheTarget;

		$this->resources = $this->loadCache();
	}

	public function isCached(string $key): bool
	{
		return array_key_exists($key, $this->resources);
	}

	public function getResource(string $key): ?array
	{
		if ($this->isCached($key) === false) {
			return null;
		}

		return $this->resources[$key];
	}

	public function save(string $key, Serializable $serializable): bool
	{
		if ($this->isCached($key)) {
			return true;
		}

		$this->resources[$key] = $serializable->serialize();
		$this->resources[$key]["_target"] = $serializable->getTarget();

		return file_put_contents($this->cacheTarget, json_encode($this->resources));
	}

	private function loadCache(): array
	{
		if (file_exists($this->cacheTarget) === false) {
			file_put_contents($this->cacheTarget, "[]");
		}

		return json_decode(file_get_contents($this->cacheTarget), true);
	}

}
