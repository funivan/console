<?php

  namespace Funivan\Console\CommandCron;

  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  class GeneralHelpInfo {

    /**
     * @return string
     */
    public static function getHelp() {
      return <<<HELP
General tag definition
<comment>[tag] [time] [options] [arguments]</comment>

Description:

<comment>tag</comment> - @crontab

<comment>time</comment> - time in cron format       (required)
       # ┌───────────── min (0 - 59)
       # │ ┌────────────── hour (0 - 23)
       # │ │ ┌─────────────── day of month (1 - 31)
       # │ │ │ ┌──────────────── month (1 - 12)
       # │ │ │ │ ┌───────────────── day of week (0 - 6) (0 to 6 are Sunday to Saturday)
       # │ │ │ │ │
       # │ │ │ │ │
       # * * * * *
      <comment>
        There is one simple difference between system crontab and current time annotation. 
        If you want to run command every/(min|hour|day|month) you should ignore first asterisk.
        For example: 
          - every 10 minutes                  : /10 * * * *
          - every 20 minutes every 3 hours    : /20 /3 * * *
      </comment>

       
<comment>options</comment>    - command options        (optional)
<comment>arguments</comment>  - command arguments      (optional)

 
<comment>Some examples:</comment>
If you want to run commands on server just add @crontab tag to command
Run command at 07:45 every day  
/**
 * @crontab 45 07 * * * 
 */

Some commands have arguments and options
Add options/arguments after time definition

/**
 * @crontab 10 10 * * * --no-cache test  
 */

HELP;

    }
  }