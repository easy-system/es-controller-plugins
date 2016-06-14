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
use Es\ControllerPlugins\Exception\ControllerPluginNotFoundException;

class ControllerPluginsTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'FakePlugin.php';
    }

    public function testMergeRegistry()
    {
        $targetConfig = [
            'foo' => 'foo',
            'bar' => 'foo',
        ];
        $target = new ControllerPlugins();
        $target->add($targetConfig);

        $sourceConfig = [
            'bar' => 'bar',
            'baz' => 'baz',
        ];
        $source = new ControllerPlugins();
        $source->add($sourceConfig);

        $return = $target->merge($source);
        $this->assertSame($return, $target);

        $expected = [
            'foo' => $targetConfig['foo'],
            'bar' => $sourceConfig['bar'],
            'baz' => $sourceConfig['baz'],
        ];
        $this->assertSame($expected, $target->getRegistry());
    }

    public function testMergeInstances()
    {
        $targetConfig = [
            'foo' => new \stdClass(),
            'bar' => new \stdClass(),
        ];
        $target = new ControllerPlugins();
        foreach ($targetConfig as $key => $item) {
            $target->set($key, $item);
        }

        $sourceConfig = [
            'bar' => new \stdClass(),
            'baz' => new \stdClass(),
        ];
        $source = new ControllerPlugins();
        foreach ($sourceConfig as $key => $item) {
            $source->set($key, $item);
        }

        $return = $target->merge($source);
        $this->assertSame($return, $target);

        $expected = [
            'foo' => $targetConfig['foo'],
            'bar' => $sourceConfig['bar'],
            'baz' => $sourceConfig['baz'],
        ];
        $this->assertSame($expected, $target->getInstances());
    }

    public function testGetPlugin()
    {
        $options = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $plugin  = $this->getMock('FakePlugin', ['setOptions']);
        $plugins = new ControllerPlugins();
        $plugins->set('foo', $plugin);

        $plugin
            ->expects($this->once())
            ->method('setOptions')
            ->with($this->identicalTo($options));

        $result = $plugins->getPlugin('foo', $options);
        $this->assertSame($result, $plugin);
    }

    public function testExteptionClassWhenPluginNotFound()
    {
        $plugins = new ControllerPlugins();
        $this->setExpectedException(ControllerPluginNotFoundException::CLASS);
        $plugins->get('foo');
    }
}
