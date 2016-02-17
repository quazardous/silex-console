<?php

namespace Quazardous\Silex\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Silex\Application as SilexApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Console extends BaseApplication
{
    /**
     * @var \Silex\Application
     */
    protected $container;

    /**
     * @return \Silex\Application
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param \Silex\SilexApplication $container
     * @param string $name
     * @param string $version
     */
    public function __construct(SilexApplication $container, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->container = $container;
        parent::__construct($name, $version);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Application::run()
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->setAutoExit(false);
        $this->getContainer()->boot();
        $this->getContainer()->flush();
        $exitCode = parent::run($input, $output);
        $this->getContainer()->terminate(new Request(), new Response());

        return $exitCode;
    }
}
