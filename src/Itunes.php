<?php

namespace Airweb\ItunesSearch;


use GuzzleHttp\Client as HttpClient;

class Itunes
{
	const ITUNES_API_URL = 'http://itunes.apple.com/';

	private static $instance;

	private $http;
	private $options;
	private $cache;

	/**
	 * Itunes constructor.
	 *
	 * @param array $options
	 */
	public function __construct(array $options = [])
	{
		$this->options = (object) $options;
		$this->cache = ItunesCache::load(!empty($this->options->cache) ? $this->options->cache : null);
	}

	/**
	 * Gets an item by bundle ID
	 *
	 * @param string $bundle
	 * @return ItunesCollection
	 */
	public function bundle(string $bundle) {
		$lookup = $this->lookup(['bundleId' => $bundle]);

		if ($lookup->count() == 0) return null;

		return $lookup->first();
	}

	/**
	 * Performs a lookup request
	 *
	 * @param array $query
	 * @return ItunesCollection
	 */
	public function lookup(array $query)
	{
		$key = $this->cache->hash($query);

		if ($this->cache->has($key)) return $this->cache->collect($key);

		$response = self::http()->get('lookup?', ['query' => $query]);
		$data = json_decode((string) $response->getBody());

		$this->cache->add($key, $data);

		return new ItunesCollection($data->results);
	}

	/**
	 * Gets an instance of Http Client
	 *
	 * @return HttpClient
	 */
	public function http() {
		if (!$this->http) {
			$this->http = new HttpClient([
				'base_uri' => self::ITUNES_API_URL
			]);
		}

		return $this->http;
	}

	/**
	 * Factory Function
	 *
	 * @param array $options
	 * @return Itunes
	 */
	public static function connect(array $options = []) {
		return new self($options);
	}
}
