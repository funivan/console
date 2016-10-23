# Console

[![Packagist](https://img.shields.io/packagist/v/funivan/console.svg)](https://packagist.org/packages/funivan/console)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/funivan/console/master.svg?style=flat-square)](https://travis-ci.org/funivan/console)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/funivan/console.svg?style=flat-square)](https://scrutinizer-ci.com/g/funivan/console/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/funivan/console.svg?style=flat-square)](https://scrutinizer-ci.com/g/funivan/console)
[![Total Downloads](https://img.shields.io/packagist/dt/funivan/console.svg?style=flat-square)](https://packagist.org/packages/funivan/console)

Improved symfony console

## Install

Via Composer

``` bash
composer require funivan/console
```

## Usage

``` php


  use Funivan\Console\CommandsLoader\FileSystemCommandsLoader;
  use Funivan\Console\NameResolver\StandardNameResolver;
  use Funivan\Console\SingleState\SingleStateConfigurator;

  $configurator = new \Funivan\Console\ConsoleApplicationConfigurator();

  $dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
  $configurator->setEventDispatcher($dispatcher);


  $finder = new \Symfony\Component\Finder\Finder();
  $finder->files()->in(__DIR__ . '/commands/')->name('*.php'); # load commands from commands dir
  
  # Base namespace is 'Commands'
  
  $commandsLoader = (new FileSystemCommandsLoader($finder, new StandardNameResolver('Commands')));
  $configurator->setCommandsLoader($commandsLoader);

  $singleStateConfigurator = new SingleStateConfigurator();
  $configurator->setSingleStateConfigurator($singleStateConfigurator);


  # configure your app
  $consoleApp = new \Funivan\Console\ConsoleApplication();
  $configurator->configure($consoleApp);
  $consoleApp->run();


```

## Testing

``` bash
    ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/funivan/Console/blob/master/CONTRIBUTING.md) for details.

## Credits

- [funivan](https://github.com/funivan)
- [All Contributors](https://github.com/funivan/Console/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
