<?php

namespace App\Infrastructure\Serializer;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class JsonToDomainObjectSerializer
{

	/**
	 * @throws \ReflectionException
	 */
	public function toDomainObject(array $data)
	{
		$target = $data["_target"];
		unset($data["_target"]);

		$domainObject = $this->unSerializeObject($target);

		$reflection = new \ReflectionClass($domainObject);

		foreach ($data as $key => $value) {
			$property = $reflection->getProperty($key);
			$property->setAccessible(true);
			$property->setValue($domainObject, $value);
		}

		return $domainObject;
	}

	/**
	 * Get domain object without calling constructor
	 */
	private function unSerializeObject(string $targetClass)
	{
		$className = $targetClass;
		$serialized = sprintf('O:%d:"%s":0:{}', strlen($className), $className);
		return unserialize($serialized, [$targetClass]);
	}

}
