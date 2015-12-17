<?php

  namespace Funivan\Console\CommandsLoader;

  use Symfony\Component\Console\Application;


  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  interface CommandsLoaderInterface {

    /**
     * @param Application $app
     */
    public function loadCommands(Application $app);

  }