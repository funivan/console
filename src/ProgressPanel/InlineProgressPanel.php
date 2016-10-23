<?php

  namespace Funivan\Console\ProgressPanel;

  use Symfony\Component\Console\Output\NullOutput;
  use Symfony\Component\Console\Output\OutputInterface;

  /**
   * If you invoke setData($message) $message will be displayed
   *  Otherwise all data will be sent to NullOutput
   *
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  class InlineProgressPanel extends ProgressPanel {

    /**
     * @var OutputInterface
     */
    private $realOutput;


    /**
     * @inheritdoc
     */
    public function __construct(OutputInterface $output, $max) {
      $this->realOutput = $output;
      parent::__construct(new NullOutput(), $max);
    }


    /**
     * @inheritdoc
     */
    public function setData($data) {
      $this->realOutput->writeln($data);
      return $this;
    }


  }