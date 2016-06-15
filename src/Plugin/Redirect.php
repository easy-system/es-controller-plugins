<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins\Plugin;

use Es\Http\Server;
use Es\Services\Provider;

/**
 * Generates redirection by given route or url.
 */
class Redirect
{
    /**
     * Sets the server.
     *
     * @param \Es\Http\Server $server The server
     *
     * @return self
     */
    public function setServer(Server $server)
    {
        Provider::getServices()->set('Server', $server);

        return $this;
    }

    /**
     * Gets the server.
     *
     * @return \Es\Http\Server The server
     */
    public function getServer()
    {
        return Provider::getServices()->get('Server');
    }

    /**
     * Sets Url plugin.
     *
     * @param Url $plugin The url plugin
     *
     * @return self
     */
    public function setUrl(Url $plugin)
    {
        $this->getPlugins()->set('url', $plugin);

        return $this;
    }

    /**
     * Gets Url plugin.
     *
     * @return Url The url plugin
     */
    public function getUrl()
    {
        return $this->getPlugins()->get('url');
    }

    /**
     * Generates redirection by given route.
     *
     * @param string $name   The route name
     * @param array  $params Optional; The route parameters
     *
     * @return \Es\Http\Psr\ResponseInterface The response
     */
    public function toRoute($name, array $params = [])
    {
        $url = $this->getUrl()->fromRoute($name, $params);

        return $this->toUrl($url);
    }

    /**
     * Generates redirection by given url.
     *
     * @param string $url        The url
     * @param int    $statusCode Optional; by default 302. The status code
     *
     * @return \Es\Http\Psr\ResponseInterface The response
     */
    public function toUrl($url, $statusCode = 302)
    {
        $server = $this->getServer();

        $response = $server->getResponse(false)
            ->withHeader('Location', $url)
            ->withStatus($statusCode);

        return $response;
    }

    /**
     * Gets controller plugins.
     *
     * @return \Es\ControllerPlugins\ControllerPlugins The plugins
     */
    protected function getPlugins()
    {
        return Provider::getServices()->get('ControllerPlugins');
    }
}
