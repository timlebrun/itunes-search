<?php

namespace Airweb\ItunesSearch;

use Illuminate\Support\Collection;

class ItunesCollection extends Collection
{
	/**
	 * Create a new collection.
	 *
	 * @param  mixed  $items
	 * @return void
	 */
	public function __construct($items = [])
	{
		// Transforms every item into an entity
		$items = array_map(function ($item) {
			return ItunesEntity::create($item);
		}, $items);

		parent::__construct($items);
	}

	// TODO handle more cases ?
}
