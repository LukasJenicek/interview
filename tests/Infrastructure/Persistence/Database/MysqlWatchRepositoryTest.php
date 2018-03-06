<?php

namespace App\Tests\Infrastructure\Persistence\Database;

use App\Application\Watch\WatchDTO;
use App\Infrastructure\Persistence\Database\MysqlWatchRepository;
use PHPUnit\Framework\TestCase;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class MysqlWatchRepositoryTest extends TestCase
{

	/**
	 * @test
	 */
	public function it_should_return_watch_dto_when_the_record_exists()
	{
		$mysqlWatchRepository = new MysqlWatchRepository();
		$dto = $mysqlWatchRepository->getWatchById(250);

		$this->assertInstanceOf(WatchDTO::class, $dto);
	}

	/**
	 * @test
	 * @expectedException \App\Infrastructure\Persistence\Database\MysqlWatchNotFoundException
	 */
	public function it_should_throw_an_exception_when_resource_does_not_exists()
	{
		$mysqlWatchRepository = new MysqlWatchRepository();
		$mysqlWatchRepository->getWatchById(255);
	}

}
