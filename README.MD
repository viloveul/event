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

class MyEvent
{
    /**
     * @var string
     */
    public $name = 'foo';
}

class MyListener
{
    /**
     * @param MyEvent $event
     */
    public function __invoke(MyEvent $event)
    {
        if ($event->name === 'foo') {
            throw new Exception("foo");
        } else {
            throw new Exception("bar");
        }
    }
}

$provider = new Viloveul\Event\Provider();
$provider->addListener(new MyListener());

$dispatcher = new Viloveul\Event\Dispatcher($provider);
$dispatcher->dispatch(new MyEvent());

```
