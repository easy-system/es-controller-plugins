<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins\Test;

use Es\ControllerPlugins\ControllerPlugins;
use Es\Services\Provider;
use Es\Services\Services;

class PluginsTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'PluginsTraitTemplate.php';
        require_once 'FakePlugin.php';
    }

    public function testGetPlugins()
    {
        $plugins  = new ControllerPlugins();
        $services = new Services();
        $services->set('ControllerPlugins', $plugins);
        Provider::setServices($services);

        $controller = new PluginsTraitTemplate();
        $this->assertSame($plugins, $controller->getPlugins());
    }

    public function testSetPlugins()
    {
        $plugins    = new ControllerPlugins();
        $controller = new PluginsTraitTemplate();
        $controller->setPlugins($plugins);
        $this->assertSame($plugins, $controller->getPlugins());
    }

    public function testPlugin()
    {
        $options = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $plugins    = $this->getMock(ControllerPlugins::CLASS);
        $controller = new PluginsTraitTemplate();
        $controller->setPlugins($plugins);

        $plugins
            ->expects($this->once())
            ->method('getPlugin')
            ->with($this->identicalTo('foo'), $this->identicalTo($options));

        $controller->plugin('foo', $options);
    }

    public function testCall()
    {
        $params  = ['foo', 'bar', 'bat'];
        $plugins = new ControllerPlugins();
        $plugin  = $this->getMock('FakePlugin', ['__invoke']);
        $plugins->set('foo', $plugin);
        $controller = new PluginsTraitTemplate();
        $controller->setPlugins($plugins);

        $plugin
            ->expects($this->once())
            ->method('__invoke')
            ->with($this->identicalTo($params));

        $controller->foo($params);
    }

    public function testCallReturnsPluginIfPluginIsNotCallable()
    {
        $plugins = new ControllerPlugins();
        $plugin  = new \stdClass();
        $plugins->set('foo', $plugin);
        $controller = new PluginsTraitTemplate();
        $controller->setPlugins($plugins);

        $return = $controller->foo();
        $this->assertSame($return, $plugin);
    }
}
