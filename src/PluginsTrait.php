<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins;

use Es\Mvc\ControllerPluginsInterface;
use Es\Services\Provider;

/**
 * Provides the functionality of the controller plugins.
 */
trait PluginsTrait
{
    /**
     * The plugins of controller.
     *
     * @var \Es\Mvc\ControllerPluginsInterface
     */
    protected $plugins;

    /**
     * Sets the plugins.
     *
     * @param \Es\Mvc\ControllerPluginsInterface $plugins The plugins
     */
    public function setPlugins(ControllerPluginsInterface $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * Gets the plugins.
     *
     * @return \Es\Mvc\ControllerPluginsInterface The plugins
     */
    public function getPlugins()
    {
        if (! $this->plugins) {
            $services = Provider::getServices();
            $plugins  = $services->get('ControllerPlugins');
            $this->setPlugins($plugins);
        }

        return $this->plugins;
    }

    /**
     * Gets plugin.
     *
     * @param string     $name    Plugin name
     * @param null|array $options Optional; plugin options
     *
     * @return mixed The requested plugin
     */
    public function plugin($name, array $options = null)
    {
        return $this->getPlugins()->getPlugin($name, (array) $options);
    }

    /**
     * The overloading returns/calls plugin.
     *
     * If plugin is callable, calls it.
     * Otherwise returns it.
     *
     * @param string     $name   Plugin name
     * @param null|array $params Optional; the plugin parameters
     *
     * @return mixed The result of calling the plugin if the plugin is
     *               callable, the plugin otherwise
     */
    public function __call($name, array $params = null)
    {
        $plugin = $this->plugin($name);
        if (is_callable($plugin)) {
            return call_user_func_array($plugin, (array) $params);
        }

        return $plugin;
    }
}
