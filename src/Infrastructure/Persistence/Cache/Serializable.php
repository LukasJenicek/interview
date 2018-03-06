<?php

namespace App\Infrastructure\Persistence\Cache;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
interface Serializable
{

	/**
	 * Return target class just a fully qualified name
	 */
	public function getTarget(): string;


	public function serialize();

}
