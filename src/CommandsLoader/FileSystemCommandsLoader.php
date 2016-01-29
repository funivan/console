<?php

  namespace Funivan\Console\CommandsLoader;

  use Funivan\Console\NameResolver\NameResolverInterface;
  use Symfony\Component\Console\Application;
  use Symfony\Component\Console\Command\Command;
  use Symfony\Component\Finder\Finder;
  use Symfony\Component\Finder\SplFileInfo;

  /**
   * @package Funivan\Console
   * @author Ivan Shcherbak <dev@funivan.com> 2015
   */
  class FileSystemCommandsLoader implements CommandsLoaderInterface {

    /**
     * @var Finder
     */
    private $filesFinder;

    /**
     * @var NameResolverInterface
     */
    private $commandNameResolver;


    /**
     * @param Finder $filesFinder
     * @param NameResolverInterface $commandNameResolver
     */
    public function __construct(Finder $filesFinder, NameResolverInterface $commandNameResolver) {
      $this->filesFinder = $filesFinder;
      $this->commandNameResolver = $commandNameResolver;
    }


    /**
     * @param Application $app
     */
    public function loadCommands(Application $app) {

      foreach ($this->filesFinder as $file) {
        /** @var SplFileInfo $file */
        $relCommandFile = $file->getRelativePathname();

        $commandClass = $this->commandNameResolver->getClassNameFromFile($relCommandFile);

        if ($commandClass === null or !class_exists($commandClass)) {
          continue;
        }

        $reflection = new \ReflectionClass($commandClass);
        if (!$reflection->isInstantiable()) {
          continue;
        }

        if (!$reflection->isSubclassOf(Command::class)) {
          continue;
        }

        $name = $this->commandNameResolver->getNameFromClass($commandClass);
        $command = new $commandClass($name);

        $app->add($command);
      }

    }


  }