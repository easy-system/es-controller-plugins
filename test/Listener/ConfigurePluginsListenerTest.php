<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins\Test\Listener;

use Es\ControllerPlugins\ControllerPlugins;
use Es\ControllerPlugins\Listener\ConfigurePluginsListener;
use Es\Modules\ModulesEvent;
use Es\Services\Services;
use Es\System\SystemConfig;

class ConfigurePluginsListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $config   = new SystemConfig();
        $services = new Services();
        $services->set('Config', $config);
        $listener = new ConfigurePluginsListener();
        $listener->setServices($services);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testSetConfig()
    {
        $config   = new SystemConfig();
        $listener = new ConfigurePluginsListener();
        $listener->setConfig($config);
        $this->assertSame($config, $listener->getConfig());
    }

    public function testGetPlugins()
    {
        $plugins  = new ControllerPlugins();
        $services = new Services();
        $services->set('ControllerPlugins', $plugins);
        $listener = new ConfigurePluginsListener();
        $listener->setServices($services);
        $this->assertSame($plugins, $listener->getPlugins());
    }

    public function testSetPlugins()
    {
        $plugins  = new ControllerPlugins();
        $listener = new ConfigurePluginsListener();
        $listener->setPlugins($plugins);
        $this->assertSame($plugins, $listener->getPlugins());
    }

    public function testInvoke()
    {
        $config  = new SystemConfig();
        $plugins = $this->getMock('Es\ControllerPlugins\ControllerPlugins');

        $pluginsConfig = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $config['controller_plugins'] = $pluginsConfig;

        $listener = new ConfigurePluginsListener();
        $listener->setPlugins($plugins);
        $listener->setConfig($config);

        $plugins
            ->expects($this->once())
            ->method('add')
            ->with($this->identicalTo($pluginsConfig));

        $listener(new ModulesEvent());
    }

    public function testInvokeDoesNothingIfConfigurationNotExists()
    {
        $config  = new SystemConfig();
        $plugins = $this->getMock('Es\ControllerPlugins\ControllerPlugins');

        $listener = new ConfigurePluginsListener();
        $listener->setPlugins($plugins);
        $listener->setConfig($config);

        $plugins
            ->expects($this->never())
            ->method('add');

        $listener(new ModulesEvent());
    }
}
