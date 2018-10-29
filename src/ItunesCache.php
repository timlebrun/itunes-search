<?php

namespace Airweb\ItunesSearch;

class ItunesCache
{
	const TTL = 120;

	/**
	 * Cache file URL if specified
	 *
	 * @var null|string
	 */
	private $file = null;

	/**
	 * Data in the cache
	 *
	 * @var array
	 */
	private $data = [];

	/**
	 * Whether something was modified in the cache
	 *
	 * @var bool
	 */
	private $dirty = false;

	/**
	 * ItunesCache constructor.
	 *
	 * @param string|null $file
	 */
	public function __construct(string $file = null)
	{
		$this->file = $file;
		if ($this->file) $content = @file_get_contents($this->file);
		$this->data = (array) json_decode(empty($content) ? null: $content);
	}

	/**
	 * Checks whether the cache has valid data for the key
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has(string $key) {
		// if does not exist
		if (empty($this->data[$key])) return false;
		// if expired
		if ($this->data[$key]->updated_at + self::TTL < time()) return false;

		// yay
		return true;
	}

	/**
	 * Gets data if valid
	 *
	 * @param string $key
	 * @return mixed|null
	 */
	public function get(string $key) {
		if (!$this->has($key)) return null;

		return $this->data[$key];
	}

	/**
	 * Gets cache in a collection of entities
	 *
	 * @param string $key
	 * @return ItunesCollection
	 */
	public function collect(string $key) {
		$data = $this->get($key);

		return new ItunesCollection($data ? $data->results : []);
	}

	/**
	 * Adds data to cache
	 *
	 * @param string $key
	 * @param $data
	 * @return $this
	 */
	public function add(string $key, $data) {
		$this->data[$key] = (object) $data;
		$this->data[$key]->updated_at = time();
		$this->dirty = true;

		return $this;
	}

	/**
	 * Saves cache in file if needed on destruct
	 */
	public function __destruct()
	{
		if ($this->dirty && $this->file) {
			$content = json_encode($this->data);
			file_put_contents($this->file, $content);
		}
	}

	/**
	 * Return unique hash
	 *
	 * @param $data
	 * @return string
	 */
	public function hash($data) {
		if (!is_string($data))
			$data = serialize($data);

		return sha1($data);
	}

	/**
	 * Factory function
	 *
	 * @param string|null $file
	 * @return ItunesCache
	 */
	public static function load(string $file = null) {
		return new self($file);
	}

}
