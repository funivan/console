<?php

  namespace Funivan\Console\CommandsLoader;

  use Symfony\Component\Console\Application;


  /**
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  interface CommandsLoaderInterface {

    /**
     * @param Application $app
     */
    public function loadCommands(Application $app);

  }