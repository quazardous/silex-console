<?php
namespace Quazardous\Silex\Provider;
use Silex\ServiceProviderInterface;
use Silex\Application;
use Quazardous\Silex\Console\ConsoleEvent;
use Quazardous\Silex\Console\ConsoleEvents;

class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $defaults = array(
            'console.name'    => 'Console',
            'console.version' => null,
            'console.class'   => 'Quazardous\Silex\Console\Console',  
        );
        
        foreach ($defaults as $key => $value) {
            if (!isset($app[$key])) {
                $app[$key] = $value;
            }
        }
        
        $app['console'] = $app->share(function() use ($app) {
            $c = $app['console.class'];
            $console = new $c(
                $app,
                $app['console.name'],
                $app['console.version']
            );
            // tell everyone the console has been initialzed
            $app['dispatcher']->dispatch(ConsoleEvents::INIT, new ConsoleEvent($console));
            return $console;
        });  
    }
    
    public function boot(Application $app)
    {
      
    }
}