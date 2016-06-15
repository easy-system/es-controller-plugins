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

use Es\Router\RouterInterface;
use Es\Services\Provider;

/**
 * Generate URLs from route definitions.
 */
class Url
{
    /**
     * Sets router.
     *
     * @param \Es\Router\RouterInterface $router The router
     *
     * @return self
     */
    public function setRouter(RouterInterface $router)
    {
        Provider::getServices()->set('Router', $router);

        return $this;
    }

    /**
     * Gets router.
     *
     * @return \Es\Router\RouterInterface The router
     */
    public function getRouter()
    {
        return Provider::getServices()->get('Router');
    }

    /**
     * Gets url from route.
     *
     * @param string $name   The route name
     * @param array  $params Optional; the route parameters
     *
     * @return string The url
     */
    public function fromRoute($name, array $params = [])
    {
        $router = $this->getRouter();
        $route  = $router->get($name);

        return $route->assemble($params);
    }
}
