<?php

  namespace Funivan\Console;

  use Funivan\Console\CommandsLoader\CommandsLoaderInterface;
  use Funivan\Console\SingleState\ConsoleSingleStateConfiguratorInterface;
  use Symfony\Component\Console\Application;
  use Symfony\Component\EventDispatcher\EventDispatcher;

  /**
   * @author Ivan Shcherbak <dev@funivan.com> 03.11.15
   */
  class ConsoleApplicationConfigurator {

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher = null;

    /**
     * @var CommandsLoaderInterface
     */
    private $commandsLoader = null;

    /**
     * @var ConsoleSingleStateConfiguratorInterface
     */
    private $singleStateConfigurator = null;


    /**
     * @param EventDispatcher $eventDispatcher
     * @return $this
     */
    public function setEventDispatcher(EventDispatcher $eventDispatcher) {
      $this->eventDispatcher = $eventDispatcher;
      return $this;
    }


    /**
     * @param CommandsLoaderInterface $commandsLoader
     * @return $this
     */
    public function setCommandsLoader(CommandsLoaderInterface $commandsLoader) {
      $this->commandsLoader = $commandsLoader;
      return $this;
    }


    /**
     * @param ConsoleSingleStateConfiguratorInterface $singleStateConfigurator
     * @return $this
     */
    public function setSingleStateConfigurator(ConsoleSingleStateConfiguratorInterface $singleStateConfigurator) {
      $this->singleStateConfigurator = $singleStateConfigurator;
      return $this;
    }


    /**
     * @param Application $app
     * @return ConsoleApplication
     */
    public function configure(Application $app) {

      $app->setCatchExceptions(false);

      if ($this->commandsLoader) {
        $this->commandsLoader->loadCommands($app);
      }

      if ($this->singleStateConfigurator) {
        if (empty($this->eventDispatcher)) {
          throw new \RuntimeException('Dispatcher component required');
        }

        $this->singleStateConfigurator->configureSingleState($this->eventDispatcher);
      }

      if (!empty($this->eventDispatcher)) {
        $app->setDispatcher($this->eventDispatcher);
      }

    }

  }