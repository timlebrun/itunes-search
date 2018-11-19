<?php

namespace Tim\ItunesSearch;

use JsonSerializable;

/**
 * Class ItunesEntity
 *
 * TODO document more properties
 * TODO map to better names
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
		return $this->attributes;
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
