<?php

  namespace Funivan\Console;

  use Funivan\Console\ProgressPanel\InlineProgressPanel;
  use Funivan\Console\ProgressPanel\ProgressPanel;
  use Symfony\Component\Console\Input\ArgvInput;
  use Symfony\Component\Console\Input\ArrayInput;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Input\InputOption;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * Base class for commands
   *
   * @package Funivan\Console
   */
  class ConsoleCommand extends \Symfony\Component\Console\Command\Command {

    /**
     * @var null|InputInterface
     */
    private $input = null;

    /**
     * @var null|OutputInterface
     */
    private $output = null;


    /**
     * @inheritdoc
     */
    protected function configure() {
      $this->addOption('no-cache', null, InputOption::VALUE_NONE, 'Disable application cache');
      $this->addOption('run-from-cron', null, InputOption::VALUE_NONE, 'Flag for custom verbosity');
      parent::configure();
    }


    /**
     * Return progress panel according to application options
     *
     * @param int $max
     * @return InlineProgressPanel|ProgressPanel
     * @throws \Exception
     */
    protected function getProgressPanel($max = 0) {
      if (empty($this->getOutput())) {
        throw new \Exception('Cant initialize progress panel. Output is undefined');
      }

      $input = $this->getInput();

      if ($input and $input->hasOption('run-from-cron') and $input->getOption('run-from-cron')) {
        return new InlineProgressPanel($this->getOutput(), $max);
      }

      return new ProgressPanel($this->getOutput(), $max);
    }


    /**
     * @inheritdoc
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
      $this->input = $input;
      $this->output = $output;

      parent::initialize($input, $output);


      if ($input->getOption('run-from-cron')) {
        $message = '[run-from-cron] [' . (new \DateTime())->format('Y-m-d H:i:s') . ']';

        if ($input instanceof ArgvInput or $input instanceof ArrayInput) {
          $message = $message . ' ' . $input;
        } else {
          $message = $message . ' ' . $this->getName();
        }

        $output->writeln($message);
      }

    }


    /**
     * We use execute method for command logic.
     *
     * @see ConsoleCommand::execute
     * @deprecated
     *
     * @param callable $code
     * @return \Symfony\Component\Console\Command\Command|void
     * @throws \Exception
     */
    public function setCode(callable $code) {
      throw new \Exception('Command setCode is deprecated');
    }


    /**
     * @return null|OutputInterface
     */
    public function getOutput() {
      return $this->output;
    }


    /**
     * @return null|InputInterface
     */
    public function getInput() {
      return $this->input;
    }


    /**
     * Run command only with single instance
     *
     * @return bool
     */
    public function isSingleInstance() {
      return false;
    }

  }