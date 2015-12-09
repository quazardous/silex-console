<?php
namespace Quazardous\Silex\Provider;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Quazardous\Silex\Console\ConsoleEvent;
use Quazardous\Silex\Console\ConsoleEvents;

class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $defaults = array(
            'console.name'    => 'Console',
            'console.version' => null,
            'console.class'   => 'Quazardous\Silex\Console\Console',  
        );
        
        foreach ($defaults as $key => $value) {
            if (!isset($pimple[$key])) {
                $pimple[$key] = $value;
            }
        }
        
        $pimple['console'] = function($c) {
            $class = $c['console.class'];
            $console = new $class(
                $c,
                $c['console.name'],
                $c['console.version']
            );
            // tell everyone the console has been initialzed
            $c['dispatcher']->dispatch(ConsoleEvents::INIT, new ConsoleEvent($console));
            return $console;
        };  
    }
}