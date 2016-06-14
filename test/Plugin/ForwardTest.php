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

use Es\ControllerPlugins\Plugin\Forward;
use Es\Dispatcher\DispatchEvent;
use Es\Events\Events;
use Es\Services\Services;

class ForwardTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'FakeControllers.php';
        require_once 'FakeController.php';
    }

    public function testGetEvents()
    {
        $events   = new Events();
        $services = new Services();
        $services->set('Events', $events);

        $plugin = new Forward();
        $plugin->setServices($services);
        $this->assertSame($events, $plugin->getEvents());
    }

    public function testSetEvents()
    {
        $events = new Events();
        $plugin = new Forward();
        $plugin->setEvents($events);
        $this->assertSame($events, $plugin->getEvents());
    }

    public function testGetControllers()
    {
        $controllers = new FakeControllers();
        $services    = new Services();
        $services->set('Controllers', $controllers);
        $plugin = new Forward();
        $plugin->setServices($services);
        $this->assertSame($controllers, $plugin->getControllers());
    }

    public function testSetControllers()
    {
        $controllers = new FakeControllers();
        $plugin      = new Forward();
        $plugin->setControllers($controllers);
        $this->assertSame($controllers, $plugin->getControllers());
    }

    public function testInvokeOnSuccess()
    {
        $params = [
            'foo' => 'bar',
        ];
        $controller  = new FakeController();
        $controllers = new FakeControllers();
        $controllers->set('FakeController', $controller);
        $events = $this->getMock(Events::CLASS, ['trigger']);

        $plugin = new Forward();
        $plugin->setControllers($controllers);
        $plugin->setEvents($events);

        $events
            ->expects($this->once())
            ->method('trigger')
            ->with($this->callback(function ($event) use ($controller) {
                if (! $event instanceof DispatchEvent) {
                    return false;
                }
                if ($controller !== $event->getContext()) {
                    return false;
                }
                if ('FakeController' !== $event->getParam('controller')) {
                    return false;
                }
                if ('fake' !== $event->getParam('action')) {
                    return false;
                }
                if ('bar' !== $event->getParam('foo')) {
                    return false;
                }

                return true;
            }));

        $plugin('FakeController', 'fake', $params);
    }

    public function testInvokeSpecifiedActionAsIndexIfActionIsNotProvided()
    {
        $controller  = new FakeController();
        $controllers = new FakeControllers();
        $controllers->set('FakeController', $controller);
        $events = $this->getMock(Events::CLASS, ['trigger']);

        $plugin = new Forward();
        $plugin->setControllers($controllers);
        $plugin->setEvents($events);

        $events
            ->expects($this->once())
            ->method('trigger')
            ->with($this->callback(function ($event) {
                if (! $event instanceof DispatchEvent) {
                    return false;
                }
                if ('index' !== $event->getParam('action')) {
                    return false;
                }

                return true;
            }));

        $plugin('FakeController');
    }

    public function invalidControllerDataProvider()
    {
        $controllers = [
            true,
            false,
            '',
            100,
            [],
            new \stdClass(),
        ];
        $return = [];
        foreach ($controllers as $controller) {
            $return[] = [$controller];
        }

        return $return;
    }

    /**
     * @dataProvider invalidControllerDataProvider
     */
    public function testInvokeRaiseExceptionIfInvalidControllerProvided($controller)
    {
        $plugin = new Forward();
        $this->setExpectedException('InvalidArgumentException');
        $plugin($controller);
    }

    public function invalidActionDataProvider()
    {
        $actions = [
            true,
            false,
            '',
            100,
            [],
            new \stdClass(),
        ];
        $return = [];
        foreach ($actions as $action) {
            $return[] = [$action];
        }

        return $return;
    }

    /**
     * @dataProvider invalidActionDataProvider
     */
    public function testInvokeRaiseExceptionIfInvalidActionProvided($action)
    {
        $plugin = new Forward();
        $this->setExpectedException('InvalidArgumentException');
        $plugin('FakeController', $action);
    }
}
