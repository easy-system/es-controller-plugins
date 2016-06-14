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

use Es\ControllerPlugins\Plugin\Url;
use Es\Route\Route;
use Es\Router\Router;
use Es\Services\Services;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRouter()
    {
        $router   = new Router();
        $services = new Services();
        $services->set('Router', $router);
        $plugin = new Url();
        $plugin->setServices($services);
        $this->assertSame($router, $plugin->getRouter());
    }

    public function testSetRouter()
    {
        $router = new Router();
        $plugin = new Url();
        $plugin->setRouter($router);
        $this->assertSame($router, $plugin->getRouter());
    }

    public function testFromRoute()
    {
        $router = $this->getMock(Router::CLASS, ['get']);
        $route  = $this->getMockBuilder(Route::CLASS)
            ->disableOriginalConstructor()
            ->setMethods(['assemble'])
            ->getMock();

        $plugin = $this->getMock(Url::CLASS, ['getRouter']);

        $routeName = 'foo';
        $routeParams = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $plugin
            ->expects($this->once())
            ->method('getRouter')
            ->will($this->returnValue($router));

        $router
            ->expects($this->once())
            ->method('get')
            ->with($this->identicalTo($routeName))
            ->will($this->returnValue($route));

        $route
            ->expects($this->once())
            ->method('assemble')
            ->with($this->identicalTo($routeParams));

        $plugin->fromRoute($routeName, $routeParams);
    }
}
