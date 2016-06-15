<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins\Test\Plugin;

use Es\ControllerPlugins\Plugin\Layout;
use Es\Services\Provider;
use Es\Services\Services;

class LayoutTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'FakeView.php';
        require_once 'FakeViewModel.php';
    }

    public function testGetView()
    {
        $view     = new FakeView();
        $services = new Services();
        $services->set('View', $view);

        Provider::setServices($services);
        $plugin = new Layout();
        $this->assertSame($view, $plugin->getView());
    }

    public function testSetView()
    {
        $services = new Services();
        Provider::setServices($services);

        $view   = new FakeView();
        $plugin = new Layout();
        $plugin->setView($view);
        $this->assertSame($view, $services->get('View'));
    }

    public function testSetTemplate()
    {
        $template = 'foo';
        $view     = $this->getMock('FakeView',      ['getLayout']);
        $model    = $this->getMock('FakeViewModel', ['setTemplate']);
        $plugin   = $this->getMock(Layout::CLASS,   ['getView']);

        $plugin
            ->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($view));

        $view
            ->expects($this->once())
            ->method('getLayout')
            ->will($this->returnValue($model));

        $model
            ->expects($this->once())
            ->method('setTemplate')
            ->with($this->identicalTo($template));

        $plugin->setTemplate($template);
    }

    public function testGetTemplate()
    {
        $template = 'foo';
        $view     = $this->getMock('FakeView',      ['getLayout']);
        $model    = $this->getMock('FakeViewModel', ['getTemplate']);
        $plugin   = $this->getMock(Layout::CLASS,   ['getView']);

        $plugin
            ->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($view));

        $view
            ->expects($this->once())
            ->method('getLayout')
            ->will($this->returnValue($model));

        $model
            ->expects($this->once())
            ->method('getTemplate')
            ->will($this->returnValue($template));

        $this->assertSame($template, $plugin->getTemplate());
    }

    public function testSetModule()
    {
        $module = 'foo';
        $view   = $this->getMock('FakeView',      ['getLayout']);
        $model  = $this->getMock('FakeViewModel', ['setModule']);
        $plugin = $this->getMock(Layout::CLASS,   ['getView']);

        $plugin
            ->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($view));

        $view
            ->expects($this->once())
            ->method('getLayout')
            ->will($this->returnValue($model));

        $model
            ->expects($this->once())
            ->method('setModule')
            ->with($this->identicalTo($module));

        $plugin->setModule($module);
    }

    public function testGetModule()
    {
        $module = 'foo';
        $view   = $this->getMock('FakeView',      ['getLayout']);
        $model  = $this->getMock('FakeViewModel', ['getModule']);
        $plugin = $this->getMock(Layout::CLASS,   ['getView']);

        $plugin
            ->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($view));

        $view
            ->expects($this->once())
            ->method('getLayout')
            ->will($this->returnValue($model));

        $model
            ->expects($this->once())
            ->method('getModule')
            ->will($this->returnValue($module));

        $this->assertSame($module, $plugin->getModule());
    }

    public function testInvokeReturnsViewModel()
    {
        $model  = new FakeViewModel();
        $view   = $this->getMock('FakeView',      ['getLayout']);
        $plugin = $this->getMock(Layout::CLASS,   ['getView']);

        $plugin
            ->expects($this->once())
            ->method('getView')
            ->will($this->returnValue($view));

        $view
            ->expects($this->once())
            ->method('getLayout')
            ->will($this->returnValue($model));

        $this->assertSame($model, $plugin());
    }

    public function testInvokeSetsTemplateAndModule()
    {
        $template = 'foo';
        $module   = 'bar';
        $plugin   = $this->getMock(Layout::CLASS,   ['setTemplate', 'setModule']);

        $plugin
            ->expects($this->at(0))
            ->method('setTemplate')
            ->with($this->identicalTo($template));

        $plugin
            ->expects($this->at(1))
            ->method('setModule')
            ->with($this->identicalTo($module));

        $plugin($template, $module);
    }
}
