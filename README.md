![](https://heatbadger.now.sh/github/readme/contributte/apitte-debug/?deprecated=1)

<p align=center>
    <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
    <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
    <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
    Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

## Disclaimer

| :warning: | This project is no longer being maintained. Please use [contributte/apitte](https://github.com/contributte/apitte).|
|---|---|

| Composer | [`apitte/debug`](https://packagist.org/packages/apitte/debug) |
|---| --- |
| Version | ![](https://badgen.net/packagist/v/apitte/debug) |
| PHP | ![](https://badgen.net/packagist/php/apitte/debug) |
| License | ![](https://badgen.net/github/license/contributte/apitte-debug) |

## About

Debug tools for [Apitte](https://github.com/apitte/core), based on [Tracy debugger](https://github.com/nette/tracy).

## Installation

To install the latest version of `apitte/debug` use [Composer](https://getcomposer.org).

```bash
composer require apitte/debug
```

## Setup

First of all, setup [core](https://github.com/apitte/core) package.

Install and register debug plugin

```neon
api:
    plugins:
        Apitte\Debug\DI\DebugPlugin:
            debug:
                panel: %debugMode%
                negotiation: %debugMode%
```

## Features

### Tracy

- bar panel - displays all router
- blue screen panel - displays endpoint with invalid schema

### Negotiation

If you have [negotiation](https://github.com/apitte/negotiation) plugin installed then you will be able to use two new suffixes.

With these suffixes you will also be able to see **Tracy bar**

`.debug`

- dumps response
- `example.com/api/v1/users.debug`

`.debugdata`

- dumps response entity
- `example.com/api/v1/users.debugdata`

## Version

| State       | Version | Branch   | Nette | PHP     |
|-------------|---------|----------|-------|---------|
| stable      | `^0.8`  | `master` | 3.0+  | `>=7.3` |
| stable      | `^0.5`  | `master` | 2.4   | `>=7.1` |

## Development

This package was maintained by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for using this package.
