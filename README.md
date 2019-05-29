# Abraxas

[![Build Status](http://img.shields.io/travis/icecave/abraxas/master.svg?style=flat-square)](https://travis-ci.org/icecave/abraxas)
[![Code Coverage](https://img.shields.io/codecov/c/github/icecave/abraxas/master.svg?style=flat-square)](https://codecov.io/github/icecave/abraxas)
[![Latest Version](http://img.shields.io/packagist/v/icecave/abraxas.svg?style=flat-square&label=semver)](https://semver.org)

**Abraxas** is very simple PHP library for generating random passwords using
a [cryptographically secure RNG](http://en.wikipedia.org/wiki/Cryptographically_secure_pseudorandom_number_generator).

    composer require icecave/abraxas

## Example

```php
$generator = new Icecave\Abraxas\PasswordGenerator;

$generator->setMinimumLength(6);
$generator->setMaximumLength(10);
$generator->setAllowAmbiguousCharacters(false);

$password = $generator->generate();
```
