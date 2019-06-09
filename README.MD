<p align="center">
<a href="https://travis-ci.com/viloveul/event">
<img src="https://travis-ci.com/viloveul/event.svg" alt="Build Status">
</a>
<a href="https://packagist.org/packages/viloveul/event">
<img src="https://poser.pugx.org/viloveul/event/d/total.svg" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/viloveul/event">
<img src="https://poser.pugx.org/viloveul/event/v/stable.svg" alt="Latest Stable Version">
</a>
</p>

# Installation

make sure your php version > 7.0

```bash
composer require viloveul/event
```

## How

```php
require __DIR__ . '/vendor/autoload.php';

$event = new Viloveul\Event\Dispatcher;

// add listener
$handlerOne = function (array $result, array $payload) {
	$result['world']++;
	return $result;
};
$priorityOne = 20;
$event->listen('hello', $handlerOne, $priorityOne);


// add listener again but hight priority
$handlerTwo = function (array $result, array $payload) {
	$result['world'] = 50;
	return $result;
};
$priorityTwo = 10;
$event->listen('hello', $handlerTwo, $priorityTwo);

// get result
$payload = ['world' => 10];
$result = $event->dispatch('hello', $payload);

var_dump($result);
```
