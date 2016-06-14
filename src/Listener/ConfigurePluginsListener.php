<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\ControllerPlugins\Listener;

use Es\Modules\ModulesEvent;
use Es\Mvc\ControllerPluginsInterface;
use Es\Services\ServicesTrait;
use Es\System\ConfigInterface;

/**
 * Configures the controller plugins.
 */
class ConfigurePluginsListener
{
    use ServicesTrait;

    /**
     * The system configuration.
     *
     * @var \Es\System\Config
     */
    protected $config;

    /**
     * The controller plugins.
     *
     * @var \Es\Mvc\ControllerPluginsInterface
     */
    protected $plugins;

    /**
     * Sets the system configuration.
     *
     * @param \Es\System\ConfigInterface $config The system configuration
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the system configuration.
     *
     * @return \Es\System\Config The system configuration
     */
    public function getConfig()
    {
        if (! $this->config) {
            $services = $this->getServices();
            $config   = $services->get('Config');
            $this->setConfig($config);
        }

        return $this->config;
    }

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
            $services = $this->getServices();
            $plugins  = $services->get('ControllerPlugins');
            $this->setPlugins($plugins);
        }

        return $this->plugins;
    }

    /**
     * Configures the controller plugins.
     *
     * @param \Es\Modules\ModulesEvent $event The module event
     */
    public function __invoke(ModulesEvent $event)
    {
        $plugins = $this->getPlugins();
        $config  = $this->getConfig();
        if (! isset($config['controller_plugins'])) {
            return;
        }
        $pluginsConfig = (array) $config['controller_plugins'];
        $plugins->add($pluginsConfig);
    }
}
