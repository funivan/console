<?php

  namespace Funivan\Console\Tests\CommandCron;

  use Cron\CronExpression;
  use DocBlockReader\Reader;
  use Funivan\Console\CommandCron\CronTaskInfo;
  use Funivan\Console\CommandCron\CronTasksFinder;
  use Funivan\Console\ConsoleApplication;
  use Funivan\Console\Tests\DummyCommand;

  /**
   *
   */
  class CronTaskInfoTest extends \PHPUnit_Framework_TestCase {

    public function testFindCronTasks() {
      $app = new ConsoleApplication();

      $command = new DummyCommand();
      $app->add($command);


      $finder = new CronTasksFinder();
      $tasks = $finder->getCronTasks($app);
      self::assertCount(0, $tasks);

      $tasks = $finder->getCronTasks($app, function (Reader $reader) {
        return $reader->getParameter('at');
      });
      self::assertCount(1, $tasks);

      /** @var CronTaskInfo $cronTaskInfo */
      $cronTaskInfo = $tasks[0];
      self::assertSame('--test', $cronTaskInfo->getArguments());
      self::assertSame('*/10 12 * * 1-4', $cronTaskInfo->getTimeExpression());

      $cronObject = $cronTaskInfo->getCronObject();
      self::assertSame('*/10', $cronObject->getExpression(CronExpression::MINUTE));
      self::assertSame('12', $cronObject->getExpression(CronExpression::HOUR));

    }

  }
