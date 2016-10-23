<?php

  namespace Funivan\Console\Tests;

  use Funivan\Console\ConsoleCommand;

  /**
   *
   */
  class ConsoleCommandTest extends \PHPUnit_Framework_TestCase {


    public function testInitializationWithName() {
      $command = new ConsoleCommand('test');
      self::assertNotEmpty($command);
    }


    public function testDefaultConfiguration() {
      $command = new ConsoleCommand('test');
      $definition = $command->getDefinition();
      self::assertTrue($definition->hasOption('run-from-cron'));
      self::assertTrue($definition->hasOption('no-cache'));
      self::assertFalse($command->isSingleInstance());
    }


    /**
     * @expectedException \Exception
     */
    public function testCommandCantNotHaveCustomCode() {
      $command = new ConsoleCommand('test');
      self::assertNotEmpty($command);
      $command->setCode(function () {
        time();
      });

    }


  }

