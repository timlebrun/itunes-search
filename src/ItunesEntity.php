<?php

namespace Tim\ItunesSearch;

use JsonSerializable;

/**
 * Class ItunesEntity
 *
 * TODO document more properties
 *
 * @package Airweb\ItunesSearch
 * @property-read string $trackViewUrl The Entity URL
 */
class ItunesEntity implements JsonSerializable
{
	/**
	 * The data of the entity
	 *
	 * @var object
	 */
	private $attributes;

	/**
	 * Keys mapping
	 *
	 * @var array
	 */
	protected $mapping = [
		'id' => 'trackId',
		'bundle' => 'bundleId',
  		'url' => 'trackViewUrl',
  		'image' => 'artworkUrl512',
  		'title' => 'trackName',
  		'name' => 'trackName',
  		'author' => 'artistName',
  		'author_link' => 'artistViewUrl',
  		'categories' => 'genres',
  		'screenshots' => 'screenshotUrls',
  		'size' => 'fileSizeBytes',
  		'supported_os' => 'supportedDevices',
  		'content_rating' => 'trackContentRating',
  		'whatsnew' => 'releaseNotes',
	];

	/**
	 * ItunesEntity constructor.
	 *
	 * @param $attributes
	 */
	public function __construct($attributes)
	{
		$this->attributes = (object) $attributes;
	}

	/**
	 * Returns data for serialization
	 *
	 * @return null
	 */
	public function jsonSerialize() {
		$output = (array) $this->attributes;

		// add mappings to json
		foreach ($this->mapping as $new => $old) {
			if (empty($output[$old])) continue;
			$output[$new] = $output[$old];
			unset($output[$old]);
		}

		return $output;
	}

	/**
	 * Gets JSON from current object
	 *
	 * @return false|mixed|string|void
	 */
	public function toJson() {
		return json_encode($this->jsonSerialize(), JSON_HEX_QUOT);
	}

	/**
	 * Magic getter
	 *
	 * @param $name
	 * @return null
	 */
	public function __get($name)
	{
		// Mapped keys first
		if (isset($this->mapping[$name])) return $this->attributes->{$this->mapping[$name]};
		if (!empty($this->attributes->$name)) return $this->attributes->$name;

		return null;
	}

	/**
	 * Factory function
	 *
	 * @param $object
	 * @return ItunesEntity
	 */
	public static function create($object) {
		return new self($object);
	}
}
