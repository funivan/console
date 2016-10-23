<?php

  namespace Funivan\Console\SingleState;

  use Funivan\Console\ConsoleCommand;
  use Symfony\Component\Console\ConsoleEvents;
  use Symfony\Component\Console\Event\ConsoleCommandEvent;
  use Symfony\Component\Console\Event\ConsoleTerminateEvent;
  use Symfony\Component\EventDispatcher\EventDispatcher;

  /**
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  class SingleStateConfigurator implements ConsoleSingleStateConfiguratorInterface {

    /**
     * @inheritdoc
     */
    public function configureSingleState(EventDispatcher $dispatcher) {
      $dispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {

        /** @var ConsoleCommand $command */
        $command = $event->getCommand();

        if (!($command instanceof ConsoleCommand) or ($command->isSingleInstance() == false)) {
          return;
        }


        $commandState = (new CommandState($command));
        if ($commandState->isAlive()) {
          $event->getOutput()->writeln('Already running: ' . $command->getName() . ' Pid:' . $commandState->getPid());
          $event->disableCommand();
        } else {
          $commandState->setPid(getmypid());
        }

      });

      $dispatcher->addListener(ConsoleEvents::TERMINATE, function (ConsoleTerminateEvent $event) {
        /** @var ConsoleCommand $command */
        $command = $event->getCommand();

        if (!($command instanceof ConsoleCommand) or ($command->isSingleInstance() == false)) {
          return;
        }

        if ($event->getExitCode() === 0) {
          (new CommandState($command))->unlink();
        }

      });
      return $dispatcher;
    }
  }