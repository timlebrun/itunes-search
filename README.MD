# iTunes Search API

This package aims to help interacting with Apple's iTunes Search API, to find stuff and things on the Store.

The API is kinda limited to about 20 requests a minute, so this package contains a small cache class and I strongly recommend using it.

## Usage
### Initializing
```php
$options = [
	'cache' => './itunes.json',
	// todo add 'ttl' => 3600,
];
$itunes = Itunes::connect($options);
$itunes->bundle('com.airweb.tixipass');

// Returns an ItunesEntity Object
```
### Lookup

Performs a Lookup request to the API

```php
$itunes->lookup([
	'key' => 'value'
]);

// Returns an ItunesCollection object containing a list of ItunesEntity objects
```

To learn what keys and value you can set here, please refer to the [Apple Documentation](https://affiliate.itunes.apple.com/resources/documentation/itunes-store-web-service-search-api/).

ItunesCollection object extends from [Laravel's Collections](https://laravel.com/docs/5.7/collections).
### Bundle ID
Its is possible to get an App by its bundle ID. It returns only a single entity, because Bundle IDs are unique. (maybe I should do the same for IDs ?).
```php
$itunes->bundle('com.airweb.tixipass');

// Returns an ItunesEntity Object
```

This package comes with a [WTFPL licence](http://www.wtfpl.net/), so don't expect support or anything from me (please, thanks).

Love, bye ♥
