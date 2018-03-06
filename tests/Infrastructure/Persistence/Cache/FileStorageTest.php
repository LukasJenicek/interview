<?php

namespace App\Tests\Infrastructure\Persistence\Cache;

use App\Infrastructure\Persistence\Cache\FileStorage;
use App\Infrastructure\Persistence\Cache\Serializable;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class FileStorageTest extends TestCase
{

	/**
	 * @var vfsStreamDirectory
	 */
	private $root;

	protected function setUp()
	{
		$this->root = vfsStream::setup("cache", 444);
	}

	/**
	 * @test
	 */
	public function it_should_create_file_on_initialization_if_not_exists()
	{
		$fileStorage = new FileStorage($this->root->url() . "/cache.json");

		$this->assertTrue($this->root->hasChild("cache.json"));

		$child = $this->root->getChild("cache.json");

		$content = file_get_contents($child->url());

		$this->assertEquals("[]", $content);
	}

	/**
	 * @test
	 */
	public function it_should_not_create_new_file_when_already_exists()
	{
		$fileContent = json_encode([
			"watch" => [
				"_target" => "some\\class",
				"id" => 125
			]
		]);

		$cacheFile = new vfsStreamFile("cache.json", 444);
		$cacheFile->setContent($fileContent);

		$this->root->addChild($cacheFile);

		$fileStorage = new FileStorage($this->root->url() . "/cache.json");

		$this->assertEquals($fileContent, file_get_contents($this->root->getChild("cache.json")->url()));
	}

	/**
	 * @test
	 */
	public function it_should_return_true_when_the_resource_is_cached()
	{
		$fileContent = json_encode([
			"watch-1" => [
				"_target" => "some\\class",
				"id" => 100,
			],
		]);

		$cacheFile = new vfsStreamFile("cache.json", 444);
		$cacheFile->setContent($fileContent);

		$this->root->addChild($cacheFile);

		$fileStorage = new FileStorage($this->root->url() . "/cache.json");

		$this->assertTrue($fileStorage->isCached("watch-1"));
	}

	/**
	 * @test
	 */
	public function it_should_add_new_resource_when_it_does_not_exists()
	{
		$fileContent = json_encode([
			"watch-1" => [
				"_target" => "some\\class",
				"id" => 100,
			],
		]);

		$cacheFile = new vfsStreamFile("cache.json", 444);
		$cacheFile->setContent($fileContent);

		$this->root->addChild($cacheFile);

		$fileStorage = new FileStorage($this->root->url() . "/cache.json");
		$serializable = $this->getMockBuilder(Serializable::class)->getMock();
		$serializable
			->method("serialize")
			->willReturn([
				"_target" => "some\\class",
				"id" => 125
			]);

		$fileStorage->save("watch-2", $serializable);

		$fileContent = file_get_contents($this->root->getChild("cache.json")->url());

		$expectedResult = json_encode([
			"watch-1" => [
				"_target" => "some\\class",
				"id" => 100
			],
			"watch-2" => [
				"_target" => "some\\class",
				"id" => 125
			]
		]);

		$this->assertEquals($expectedResult, $fileContent);
	}

	/**
	 * @test
	 */
	public function it_should_return_resource_when_it_exists()
	{
		$fileContent = json_encode([
			"watch-1" => [
				"_target" => "some\\class",
				"id" => 100,
			],
		]);

		$cacheFile = new vfsStreamFile("cache.json", 444);
		$cacheFile->setContent($fileContent);

		$this->root->addChild($cacheFile);

		$fileStorage = new FileStorage($this->root->url() . "/cache.json");
		$resource = $fileStorage->getResource("watch-1");

		$this->assertCount(2, $resource);
		$this->assertArrayHasKey("_target", $resource);
		$this->assertArrayHasKey("id", $resource);
	}

}
