# Apitte Debug

Debug tools for [Apitte](https://github.com/apitte/core), based on [Tracy debugger](https://github.com/nette/tracy).

## Content

- [Setup](#setup)
- [Tracy](#tracy)
- [Negotiation](#negotiation)

## Setup

First of all, setup [core](https://github.com/apitte/core) package.

Install and register debug plugin

```bash
composer require apitte/debug
```

```yaml
api:
    plugins: 
        Apitte\Debug\DI\DebugPlugin:
            debug:
                panel: %debugMode%
                negotiation: %debugMode%
```

## Tracy

- bar panel - displays all router
- blue screen panel - displays endpoint with invalid schema

## Negotiation

If you have [negotiation](https://github.com/apitte/negotiation) plugin installed then you will be able to use two new suffixes.

With these suffixes you will also be able to see **Tracy bar**

`.debug`

- dumps response
- `example.com/api/v1/users.debug`

`.debugdata`

- dumps response entity
- `example.com/api/v1/users.debugdata`
