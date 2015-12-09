# Quazardous Silex Console Provider
Yet another one.

## Intstallation

Add quazardous/silex-console to your composer.json and register the service.

```php
$app->register(new Quazardous\Silex\Provider\ConsoleServiceProvider);

```

You can customize the provider with parameters :
- console.name
- console.version
- console.class

See tests/console.php for a full working minimum example.

## Silex integration

The run() function triggers Silex\Application::boot() and Silex\Application::terminate();

## Knp compatibility
https://github.com/KnpLabs/ConsoleServiceProvider

The provider dispatch a 'console.init' event like the Knp Console Provider. You can use it to register the commands.

