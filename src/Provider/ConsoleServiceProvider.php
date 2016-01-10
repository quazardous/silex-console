<?php

namespace Quazardous\Silex\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Quazardous\Silex\Console\ConsoleEvent;
use Quazardous\Silex\Console\ConsoleEvents;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

class ConsoleServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $defaults = array(
            'console.name' => 'Console',
            'console.version' => null,
            'console.class' => 'Quazardous\Silex\Console\Console',
        );

        foreach ($defaults as $key => $value) {
            if (!isset($app[$key])) {
                $app[$key] = $value;
            }
        }

        $app['console'] = function ($c) {
            $class = $c['console.class'];
            $console = new $class(
                $c,
                $c['console.name'],
                $c['console.version']
            );

            return $console;
        };
    }

    public function boot(Application $app)
    {
        // tell everyone the console is ready
        $app['dispatcher']->dispatch(ConsoleEvents::INIT, new ConsoleEvent($app['console']));
    }
}
