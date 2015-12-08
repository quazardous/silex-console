<?php
namespace Quazardous\Silex\Console;
use Symfony\Component\EventDispatcher\Event;
use Quazardous\Silex\Console\Console;

class ConsoleEvent extends Event
{
    const INIT = 'console.init';
    protected $console;
    
    public function __construct(Console $console)
    {
        $this->console = $console;
    }

    /**
     *
     * @return \Quazardous\Silex\Console\Console
     */
    public function getConsole()
    {
        return $this->console;
    }
    
    /**
     * For Knp compatibility.
     * @return \Quazardous\Silex\Console\Console
     */
    public function getApplication()
    {
        return $this->getConsole();
    }
}