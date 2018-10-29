<?php

namespace Airweb\ItunesSearch;

/**
 * Class ItunesEntity
 *
 * TODO document more properties
 * TODO map to better names
 *
 * @package Airweb\ItunesSearch
 * @property-read string $trackViewUrl The Entity URL
 */
class ItunesEntity
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
