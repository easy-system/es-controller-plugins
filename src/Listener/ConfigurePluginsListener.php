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
use Es\Services\Provider;
use Es\System\ConfigTrait;

/**
 * Configures the controller plugins.
 */
class ConfigurePluginsListener
{
    use ConfigTrait;

    /**
     * Sets the plugins.
     *
     * @param \Es\Mvc\ControllerPluginsInterface $plugins The plugins
     */
    public function setPlugins(ControllerPluginsInterface $plugins)
    {
        Provider::getServices()->set('ControllerPlugins', $plugins);
    }

    /**
     * Gets the plugins.
     *
     * @return \Es\Mvc\ControllerPluginsInterface The plugins
     */
    public function getPlugins()
    {
        return Provider::getServices()->get('ControllerPlugins');
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
        if (isset($config['controller_plugins'])) {
            $pluginsConfig = (array) $config['controller_plugins'];
            $plugins->add($pluginsConfig);
        }
    }
}
