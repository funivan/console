<?php

  namespace Funivan\Console\SingleState;

  use Symfony\Component\EventDispatcher\EventDispatcher;


  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  interface ConsoleSingleStateConfiguratorInterface {

    /**
     * @param EventDispatcher $dispatcher
     * @return void
     */
    public function configureSingleState(EventDispatcher $dispatcher);
  }