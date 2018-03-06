<?php

namespace App\Tests\Infrastructure\Serializer;

use App\Domain\Watch\Watch;
use App\Infrastructure\Serializer\JsonToDomainObjectSerializer;
use PHPUnit\Framework\TestCase;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class JsonToDomainObjectSerializerTest extends TestCase
{

	/**
	 * @test
	 */
	public function it_returns_domain_object()
	{
		$jsonToDomainObjectSerializer = new JsonToDomainObjectSerializer();

		/** @var Watch $domainObject */
		$domainObject = $jsonToDomainObjectSerializer->toDomainObject([
			"_target" => Watch::class,
			"id" => 1,
			"title" => "New watch",
			"price" => 200,
			"description" => "New watch with cool fountain"
		]);

		$this->assertInstanceOf(Watch::class, $domainObject);

		$this->assertEquals(1, $domainObject->getId());
		$this->assertEquals("New watch", $domainObject->getTitle());
		$this->assertEquals(200, $domainObject->getPrice());
		$this->assertEquals("New watch with cool fountain", $domainObject->getDescription());
	}
}
