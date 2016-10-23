<?php

  namespace Funivan\Console\CommandCron;

  use DocBlockReader\Reader;
  use Symfony\Component\Console\Application;


  /**
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  class CronTasksFinder {


    /**
     * @param Application $application
     * @param callback|null $filter
     * @return CronTaskInfo[]
     */
    public function getCronTasks(Application $application, $filter = null) {

      if ($filter === null) {
        $filter = function (Reader $reader) {
          return $reader->getParameter('crontab');
        };
      }

      if (!is_callable($filter)) {
        throw new \InvalidArgumentException('Invalid filter callback');
      }

      $tasks = [];

      foreach ($application->all() as $command) {
        $reader = new \DocBlockReader\Reader(get_class($command));

        $crontabAnnotations = $filter($reader);

        if (empty($crontabAnnotations)) {
          continue;
        }

        if (!is_array($crontabAnnotations)) {
          $crontabAnnotations = [$crontabAnnotations];
        }

        foreach ($crontabAnnotations as $crontabExpression) {
          $commandArguments = preg_split('!\s+!', $crontabExpression, -1, PREG_SPLIT_NO_EMPTY);
          array_splice($commandArguments, 0, 5);

          $commandArguments = implode(' ', $commandArguments);
          $preparedExpression = trim(str_replace([" /", $commandArguments], [' */', ''], " " . $crontabExpression));
          $tasks[] = new CronTaskInfo($preparedExpression, $command, $commandArguments);

        }
      }


      return $tasks;
    }

  }