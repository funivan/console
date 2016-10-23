<?php

  namespace Funivan\Console\NameResolver;


  /**
   * @author Ivan Shcherbak <dev@funivan.com>
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