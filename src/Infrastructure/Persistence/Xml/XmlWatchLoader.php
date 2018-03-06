<?php

namespace App\Infrastructure\Persistence\Xml;

/**
 * @author Lukas Jenicek <lukas.jenicek5@gmail.com>
 */
class XmlWatchLoader
{

	/**
	 * @var string
	 */
	private $xmlPath;

	public function __construct(string $xmlPath)
	{
		$this->xmlPath = $xmlPath;
	}

	/**
	 * @throws XmlLoaderException
	 */
	public function loadByIdFromXml(string $watchIdentification): ?array
	{
		$watch = null;

		if (file_exists($this->xmlPath) === false) {
			throw new XmlLoaderException("File does not exist {$this->xmlPath}");
		}

		$file = simplexml_load_file($this->xmlPath);

		if ($file === false) {
			throw new XmlLoaderException("File {$this->xmlPath} couldn't be open");
		}

		foreach ($file as $w) {
			$identification = (string) $w->attributes()->identification;

			if ($identification === $watchIdentification) {
				$watch = [
					"id" => (int) $w->id,
					"title" => (string) $w->title,
					"price" => (int) $w->price,
					"desc" => (string) $w->desc
				];

				break;
			}
		}

		return $watch;
	}

}
