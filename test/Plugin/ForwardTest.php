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
use Es\Controllers\Controllers;
use Es\Dispatcher\DispatchEvent;
use Es\Events\Events;
use Es\Services\Services;
use Es\Services\ServicesTrait;

class ForwardTest extends \PHPUnit_Framework_TestCase
{
    use ServicesTrait;

    public function setUp()
    {
        require_once 'FakeController.php';
    }

    public function testGetControllers()
    {
        $controllers = new Controllers();
        $services    = new Services();
        $services->set('Controllers', $controllers);

        $this->setServices($services);
        $plugin = new Forward();
        $this->assertSame($controllers, $plugin->getControllers());
    }

    public function testSetControllers()
    {
        $services = new Services();
        $this->setServices($services);

        $controllers = new Controllers();
        $plugin      = new Forward();
        $plugin->setControllers($controllers);
        $this->assertSame($controllers, $services->get('Controllers'));
    }

    public function testInvokeOnSuccess()
    {
        $params = [
            'foo' => 'bar',
        ];
        $controller  = new FakeController();
        $controllers = new Controllers();
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
        $controllers = new Controllers();
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
