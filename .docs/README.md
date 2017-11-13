# Apitte/Debug

## Content

- [Installation - how to register a plugin](#plugin)
- [Tracy - debugging](#tracy)
- [Playground - real examples](#playground)

## Plugin

```
composer require apitte/debug
```

This package depends on `apitte/core`, so you have to register `ApiExtension` from that package.

```yaml
extensions:
    api: Apitte\Core\DI\ApiExtension
```

To enable this plugin you should place `DebugPlugin` under `plugins` key. 

```yaml
api:
    plugins:
        Apitte\Debug\DI\DebugPlugin:
```

## Tracy

This plugin adds 2 Tracy extensions:

- panel
- bluescreen panel

## Playground

I've made a repository with full applications for education.

Take a look: https://github.com/apitte/playground
