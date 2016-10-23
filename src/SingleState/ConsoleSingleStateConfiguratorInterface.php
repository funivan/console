<?php

  namespace Funivan\Console\SingleState;

  use Symfony\Component\EventDispatcher\EventDispatcher;


  /**
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  interface ConsoleSingleStateConfiguratorInterface {

    /**
     * @param EventDispatcher $dispatcher
     * @return void
     */
    public function configureSingleState(EventDispatcher $dispatcher);
  }