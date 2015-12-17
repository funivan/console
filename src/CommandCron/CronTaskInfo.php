<?php

  namespace Funivan\Console\CommandCron;

  use Symfony\Component\Console\Command\Command;


  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  class CronTaskInfo {

    /**
     * @var string
     */
    protected $timeExpression;

    /**
     * @var Command
     */
    protected $command;

    /**
     * @var string
     */
    protected $arguments;


    /**
     *
     * @param string $timeExpression
     * @param Command $command
     * @param string $arguments
     */
    public function __construct($timeExpression, Command $command, $arguments = '') {
      $this->timeExpression = $timeExpression;
      $this->command = $command;
      $this->arguments = $arguments;
    }


    /**
     * @throws \InvalidArgumentException if not a valid CRON expression
     * @return \Cron\CronExpression
     */
    public function getCronObject() {
      return \Cron\CronExpression::factory($this->timeExpression);
    }


    /**
     * @return string
     */
    public function getTimeExpression() {
      return $this->timeExpression;
    }


    /**
     * @return Command
     */
    public function getCommand() {
      return $this->command;
    }


    /**
     * @return string
     */
    public function getArguments() {
      return $this->arguments;
    }


  }