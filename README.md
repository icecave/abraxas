# Abraxas

[![Build Status]](https://travis-ci.org/IcecaveStudios/abraxas)
[![Test Coverage]](https://coveralls.io/r/IcecaveStudios/abraxas?branch=develop)
[![SemVer]](http://semver.org)

**Abraxas** is a simple password generation library for PHP.

* Install via [Composer](http://getcomposer.org) package [icecave/abraxas](https://packagist.org/packages/icecave/abraxas)
* Read the [API documentation](http://icecavestudios.github.io/abraxas/artifacts/documentation/api/)

## Example

```php
$generator = new Icecave\Abraxas\PasswordGenerator;

$generator->setMinimumLength(6);
$generator->setMaximumLength(10);
$generator->setAllowAmbiguousCharacters(false);

$password = $generator->generate();
```

<!-- references -->
[Build Status]: http://img.shields.io/travis/IcecaveStudios/abraxas/develop.svg
[Test Coverage]: http://img.shields.io/coveralls/IcecaveStudios/abraxas/develop.svg
[SemVer]: http://img.shields.io/:semver-0.0.0-red.svg
