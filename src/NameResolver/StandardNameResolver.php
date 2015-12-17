<?php

  namespace Funivan\Console\NameResolver;

  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  class StandardNameResolver implements NameResolverInterface {

    /**
     * @var string
     */
    private $namespace;


    /**
     * @param string $namespace
     */
    public function __construct($namespace) {
      if (!is_string($namespace)) {
        throw new \InvalidArgumentException('Namespace should be string');
      }
      $this->namespace = '\\' . trim($namespace, '\\') . '\\';
    }


    /**
     * @param string $class
     * @return string
     */
    public function getNameFromClass($class) {
      return implode(':',
        array_map(
          'lcfirst',
          array_slice(explode(
            '\\',
            trim($class, '\\')
          ), 1)
        )
      );
    }


    /**
     * @param string $name
     * @return string
     */
    public function getClassFromName($name) {
      $parts = explode(':', $name);
      $parts = array_map('ucfirst', $parts);
      return $this->namespace . implode('\\', $parts);

    }


    /**
     * @param string $relCommandFile
     * @return string
     */
    public function getClassNameFromFile($relCommandFile) {
      $commandName = str_replace('/', ':', $relCommandFile);
      $commandName = str_replace('.php', '', $commandName);
      $commandClass = $this->namespace . str_replace(':', '\\', $commandName);
      return $commandClass;
    }

  }