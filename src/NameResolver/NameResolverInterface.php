<?php

  namespace Funivan\Console\NameResolver;


  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  interface NameResolverInterface {

    /**
     * @param string $class
     * @return string
     */
    public function getNameFromClass($class);


    /**
     * @param string $name
     * @return string
     */
    public function getClassFromName($name);


    /**
     * @param string $relCommandFile
     * @return string
     */
    public function getClassNameFromFile($relCommandFile);
  }