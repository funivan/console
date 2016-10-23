<?
  namespace Funivan\Console\ProgressPanel;

  use Symfony\Component\Console\Helper\ProgressBar;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * Extended progress bar
   * Progress bar attached to the bottom of the console
   * You can add some data to output by setData method
   *
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  class ProgressPanel extends \Symfony\Component\Console\Helper\ProgressBar {

    /**
     * Configure progress panel
     *
     * @param OutputInterface $output
     * @param int $max
     */
    public function __construct(OutputInterface $output, $max = 0) {

      static::setPlaceholderFormatterDefinition('current', function (ProgressBar $bar) {
        return $bar->getProgress();
      });

      parent::__construct($output, $max);

      if ($max === 0) {
        $this->setFormat('%data% %current% [%bar%]  %elapsed:10s% / %memory:-10s%  %itemsPerSecond:-10s% %message%');
      } else {
        $this->setFormat('%data% %current%/%max% [%bar%] %percent:3s%% %elapsed:10s% / %estimated:-10s% %memory:-10s%  %itemsPerSecond:-10s% %message%');
      }
      $this->setMessage('', 'data');
      $this->setMessage('');

      $this->setPlaceholderFormatterDefinition('itemsPerSecond', function (ProgressBar $bar) {

        $seconds = (time() - $bar->getStartTime());
        $seconds = empty($seconds) ? 1 : $seconds;
        $display = round($bar->getProgress() / ($seconds)) . ' i/s';

        return $display;
      });

    }


    /**
     * @param int $step
     */
    public function setProgress($step) {
      $this->setMessage('', 'data');
      parent::setProgress($step);
    }


    /**
     * @param string $data
     * @return $this
     */
    public function setData($data) {
      $this->clear();
      $this->setMessage($data . "\n", 'data');
      $this->display();
      $this->setMessage('', 'data');

      return $this;
    }

  }