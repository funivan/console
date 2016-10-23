<?

  namespace Funivan\Console\Tests;

  use Funivan\Console\ConsoleCommand;
  use Symfony\Component\Console\Input\InputInterface;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * @at /10 12 * * 1-4   --test
   */
  class DummyCommand extends ConsoleCommand {

    public function __construct($name = null) {
      $name = !empty($name) ? $name : 'dummyCommand';
      parent::__construct($name);
    }


    protected function execute(InputInterface $input, OutputInterface $output) {
      $output->write('start command');
    }

  }
