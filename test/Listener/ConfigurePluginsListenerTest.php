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
use Es\Services\Provider;
use Es\Services\Services;
use Es\System\SystemConfig;

class ConfigurePluginsListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPlugins()
    {
        $plugins  = new ControllerPlugins();
        $services = new Services();
        $services->set('ControllerPlugins', $plugins);

        Provider::setServices($services);
        $listener = new ConfigurePluginsListener();
        $this->assertSame($plugins, $listener->getPlugins());
    }

    public function testSetPlugins()
    {
        $services = new Services();
        Provider::setServices($services);

        $plugins  = new ControllerPlugins();
        $listener = new ConfigurePluginsListener();
        $listener->setPlugins($plugins);
        $this->assertSame($plugins, $services->get('ControllerPlugins'));
    }

    public function testInvoke()
    {
        $config  = new SystemConfig();
        $plugins = $this->getMock(ControllerPlugins::CLASS);

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
}
