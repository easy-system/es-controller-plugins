Usage
=====

# Basic usage

Use the `Es\ControllerPlugins\PluginsTrait` to obtain the functionality of 
plugins in your controller:
```
use Es\ControllerPlugins\PluginsTrait;

class ExampleController
{
    use PluginsTrait;

    public function fooAction()
    {
        $result = $this->forward('Foo.Bar.Baz', 'index');
        // ...
    }
}
```

# The custom plugins

The module can provide configuration of custom controller plugins. By convention,
this configuration should be located in a separate file `controller-plugins.config.php`
in the configuration directory of module. This file must be included with the
system configuration file:
```
project/
    module/
        ExampleModule/
            Module.php
            config/
                system.config.php
                controller-plugins.config.php
            src/
            ...
```

The file `project/module/ExampleModule/config/system.config.php`:
```
return [
    'controller_plugins' => require __DIR__ . DIRECTORY_SEPARATOR . 'controller-plugins.config.php',
];
```

The file `project/module/ExampleModule/config/controller-plugins.config.php`:
```
return [
    'foo' => 'ExampleModule\ControllerPlugin\FooPlugin',
    'bar' => 'ExampleModule\ControllerPlugin\BarPlugin',
    // ...
];
``` 

Then you can use a custom plugin in the usual way:
```
use Es\ControllerPlugins\PluginsTrait;

class ExampleController
{
    use PluginsTrait;

    public function indexAction()
    {
        $foo = $this->foo();
        $bar = $this->bar();
        // ...
    }
}
```
If the plugin is callable, `$this->foo()` from example above will returns the 
result of call the plugin. Otherwise, it will returns the instance of plugin.
