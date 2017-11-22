# Apitte/Debug

## Content

- [Installation - how to register a plugin](#plugin)
- [Tracy - debugging](#tracy)
- [Playground - real examples](#playground)

## Plugin

This plugin requires [Apitte/Core](https://github.com/apitte/core) library.

At first you have to register the main extension.

```yaml
extensions:
    api: Apitte\Core\DI\ApiExtension
```

Secondly, add the `DebugPlugin` plugin.

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
