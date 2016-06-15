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

use Es\ControllerPlugins\ControllerPlugins;
use Es\ControllerPlugins\Plugin\Redirect;
use Es\ControllerPlugins\Plugin\Url;
use Es\Http\Server;
use Es\Services\Provider;
use Es\Services\Services;
use Psr\Http\Message\ResponseInterface;

class RedirectTest extends \PHPUnit_Framework_TestCase
{
    public function testGetServer()
    {
        $server   = new Server();
        $services = new Services();
        $services->set('Server', $server);

        Provider::setServices($services);
        $plugin = new Redirect();
        $this->assertSame($server, $plugin->getServer());
    }

    public function testSetServer()
    {
        $services = new Services();
        Provider::setServices($services);

        $server = new Server();
        $plugin = new Redirect();
        $plugin->setServer($server);
        $this->assertSame($server, $services->get('Server'));
    }

    public function testGetUrl()
    {
        $url     = new Url();
        $plugins = new ControllerPlugins();
        $plugins->set('url', $url);
        $services = new Services();
        $services->set('ControllerPlugins', $plugins);

        Provider::setServices($services);
        $plugin = new Redirect();
        $this->assertSame($url, $plugin->getUrl());
    }

    public function testSetUrl()
    {
        $services = new Services();
        $plugins  = new ControllerPlugins();
        $services->set('ControllerPlugins', $plugins);
        Provider::setServices($services);

        $url    = new Url();
        $plugin = new Redirect();
        $plugin->setUrl($url);
        $this->assertSame($url, $plugins->get('url'));
    }

    public function testToUrl()
    {
        $server = new Server();
        $plugin = new Redirect();
        $plugin->setServer($server);
        $result = $plugin->toUrl('/foo', 307);
        $this->assertInstanceOf(ResponseInterface::CLASS, $result);
        $this->assertSame($result->getHeader('Location'), ['/foo']);
        $this->assertSame($result->getStatusCode(), 307);
    }

    public function testToRoute()
    {
        $url    = $this->getMock(Url::CLASS);
        $server = new Server();
        $plugin = new Redirect();
        $plugin->setServer($server);
        $plugin->setUrl($url);

        $routeName   = 'foo';
        $routeParams = ['foo' => 'bar'];
        $assembled   = '/foo';

        $url
            ->expects($this->once())
            ->method('fromRoute')
            ->with(
                $this->identicalTo($routeName),
                $this->identicalTo($routeParams)
            )
            ->will($this->returnValue($assembled));

        $result = $plugin->toRoute($routeName, $routeParams);
        $this->assertInstanceOf(ResponseInterface::CLASS, $result);
        $this->assertSame($result->getHeader('Location'), [$assembled]);
        $this->assertSame(302, $result->getStatusCode());
    }
}
