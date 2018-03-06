<?php

namespace App\Tests\Infrastructure\Persistence\Xml;

use App\Infrastructure\Persistence\Xml\XmlWatchLoader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class XmlWatchLoaderTest extends TestCase
{

	/**
	 * @var vfsStreamDirectory
	 */
	private $root;

	protected function setUp()
	{
		$this->root = vfsStream::setup("storage", 444);
	}

	/**
	 * @test
	 * @expectedException \App\Infrastructure\Persistence\Xml\XmlLoaderException
	 */
	public function it_should_fail_when_xml_storage_file_does_not_exist()
	{
		$xmlWatchLoader = new XmlWatchLoader($this->root->url() . "/watchstore.xml");

		$xmlWatchLoader->loadByIdFromXml(250);
	}

	/**
	 * @test
	 */
	public function it_should_return_array_when_the_xml_file_is_valid()
	{
		$xmlContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
			<watches>
				<watch identification='watch-250'>
					<id>250</id>
					<title>Watch with water fountain</title>
					<price>200</price>
					<desc>Beautifully crafted timepiece for every gentleman.</desc>
				</watch>
				<watch identification='watch-255'>
					<id>255</id>
					<title>Watch with water fountain</title>
					<price>300</price>
					<desc>Beautifully crafted timepiece for every gentleman.</desc>
				</watch>
			</watches>
		";

		$xmlFile = new vfsStreamFile("watchstore.xml", 444);
		$xmlFile->setContent($xmlContent);

		$this->root->addChild($xmlFile);

		$xmlWatchLoader = new XmlWatchLoader($this->root->url() . "/watchstore.xml");
		$watch = $xmlWatchLoader->loadByIdFromXml(250);


		$this->assertCount(4, $watch);
		$this->assertEquals($watch["id"], 250);
		$this->assertEquals($watch["title"], "Watch with water fountain");
		$this->assertEquals($watch["price"], 200);
		$this->assertEquals($watch["description"], "Beautifully crafted timepiece for every gentleman.");

	}

}
