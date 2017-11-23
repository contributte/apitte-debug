# Apitte/Debug

## Content

- [Installation - how to register a plugin](#plugin)
- [Tracy - debugging](#tracy)
- [Bridges - extra features](#bridges)
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

## Bridges

### Apitte/Negotiation

This plugin also adds some extra features if you use `apitte/negotiation`. At first take a [quick look at documentation](https://github.com/apitte/negotiation/tree/master/.docs). 

This plugins register 2 more transformers:

- `DebugTransformer` - You can type `example.com/user.debug` and you'll see dump of `Apitte\Core\Http\ApiResponse`. In case of exception, you'll see the Tracy-exception.

- `DebugDataTransformer` - You can type `example.com/user.debugdata` and you'll see dump of response entity data.

## Playground

I've made a repository with full applications for education.

Take a look: https://github.com/apitte/playground
