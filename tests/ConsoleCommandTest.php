<?php

  namespace Funivan\Console\Tests;

  use Funivan\Console\ConsoleCommand;
  use Symfony\Component\Console\Input\ArrayInput;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Output\BufferedOutput;
  use Symfony\Component\Console\Output\OutputInterface;

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


    public function testOutput() {
      $command = new class extends ConsoleCommand {

        public function __construct($name = null) {
          $name = $name ? $name : 'test command';
          parent::__construct($name);
        }


        protected function execute(InputInterface $input, OutputInterface $output) {
          $output->write('start command');
        }

      };

      self::assertNull($command->getOutput());

      $output = new BufferedOutput();
      $output->writeln('start buffer');

      $command->run(new ArrayInput([]), $output);


      $output = $command->getOutput();
      self::assertInstanceOf(BufferedOutput::class, $output);
      /** @var BufferedOutput $output */
      $lines = explode("\n", $output->fetch());
      self::assertSame([
        'start buffer',
        'start command',
      ], $lines);

    }


  }

