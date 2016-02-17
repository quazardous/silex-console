#!/usr/bin/env php
<?php
include __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application;

$app['name'] = 'My nice Silex app';

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

class TestCommandProvider implements Pimple\ServiceProviderInterface, Silex\Api\BootableProviderInterface {
    public function register(Pimple\Container $app) {

    }
    public function boot(Silex\Application $app) {
        echo "Silex is booting: test OK\n";
        $app['dispatcher']->addListener(Quazardous\Silex\Console\ConsoleEvents::INIT, function(Quazardous\Silex\Console\ConsoleEvent $event) {
            echo "Adding TestCommand(): test OK\n";
            $event->getConsole()->add(new TestCommand());
        });
    }
}

$app->register(new TestCommandProvider);

// should be the last registered provider
$app->register(new Quazardous\Silex\Provider\ConsoleServiceProvider);

echo "\n\n**Should say that Silex is booting and adding TestCommand()...**\n\n";

$code = $app['console']->run();

exit($code);
