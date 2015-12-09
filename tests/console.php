#!/usr/bin/env php
<?php
include __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application;

$app['name'] = 'My nice Silex app';

$app->register(new Quazardous\Silex\Provider\ConsoleServiceProvider);

class TestCommand extends Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('quazardous:command:test');
    }
    protected function execute(Symfony\Component\Console\Input\InputInterface $input, Symfony\Component\Console\Output\OutputInterface $output)
    {
        $app = $this->getApplication()->getContainer();
        echo "I'm in {$app['name']} !\n";
    }
}

class TestCommandProvider implements Silex\ServiceProviderInterface {
    public function register(Silex\Application $app) {
        $app['dispatcher']->addListener(Quazardous\Silex\Console\ConsoleEvent::INIT, function(Quazardous\Silex\Console\ConsoleEvent $event) {
            echo "Adding TestCommand(): test OK\n";
            $event->getConsole()->add(new TestCommand());
        });
    }
    public function boot(Silex\Application $app) {
        echo "Silex is booting: test OK\n";
    }
}

$app->register(new TestCommandProvider);

echo "\n\n**Should say that Silex is booting and adding TestCommand()...**\n\n";

$app['console']->run();

