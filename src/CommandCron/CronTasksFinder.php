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
     * @param callable|null $annotationFinder
     * @return CronTaskInfo[]
     */
    public function getCronTasks(Application $application, callable $annotationFinder = null) {

      if ($annotationFinder === null) {
        $annotationFinder = function (Reader $reader) {
          return $reader->getParameter('crontab');
        };
      }

      $tasks = [];

      foreach ($application->all() as $command) {
        $reader = new Reader(get_class($command));

        $crontabAnnotations = $annotationFinder($reader);

        if (empty($crontabAnnotations)) {
          continue;
        }

        $crontabAnnotations = (array) $crontabAnnotations;

        foreach ($crontabAnnotations as $crontabExpression) {
          $commandArguments = preg_split('!\s+!', $crontabExpression, -1, PREG_SPLIT_NO_EMPTY);
          array_splice($commandArguments, 0, 5);

          $commandArguments = implode(' ', $commandArguments);
          $preparedExpression = trim(str_replace([' /', $commandArguments], [' */', ''], ' ' . $crontabExpression));
          $tasks[] = new CronTaskInfo($preparedExpression, $command, $commandArguments);

        }
      }

      return $tasks;
    }

  }