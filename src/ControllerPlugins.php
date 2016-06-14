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
use Es\Services\ServiceLocator;

/**
 * The Collection of controller plugins. Provides plugins on demand.
 */
class ControllerPlugins extends ServiceLocator implements ControllerPluginsInterface
{
    /**
     * The class of exception, which should be raised if the requested plugin
     * is not found.
     */
    const NOT_FOUND_EXCEPTION = 'Es\ControllerPlugins\Exception\ControllerPluginNotFoundException';

    /**
     * The message of exception, that thrown when unable to find the requested
     * plugin.
     *
     * @var string
     */
    const NOT_FOUND_MESSAGE = 'Not found; the Controllers Plugin "%s" is unknown.';

    /**
     * The message of exception, that thrown when unable to build the requested
     * plugin.
     *
     * @var string
     */
    const BUILD_FAILURE_MESSAGE = 'Failed to create the Controllers Plugin "%s".';

    /**
     * The message of exception, that thrown when added of invalid
     * plugin specification.
     *
     * @var string
     */
    const INVALID_ARGUMENT_MESSAGE = 'Invalid specification of Controllers Plugin "%s"; expects string, "%s" given.';

    /**
     * Gets the plugin and sets its options.
     *
     * @param string $name    The plugin name
     * @param array  $options Optional; the plugin options
     *
     * @return mixed The requested plugin
     */
    public function getPlugin($name, array $options = [])
    {
        $plugin = $this->get($name);
        if (! empty($options) && is_callable([$plugin, 'setOptions'])) {
            $plugin->setOptions($options);
        }

        return $plugin;
    }

    /**
     * Merges with other plugins.
     *
     * @param \Es\Mvc\ControllerPluginsInterface $source The data source
     *
     * @return self
     */
    public function merge(ControllerPluginsInterface $source)
    {
        $this->registry  = array_merge($this->registry, $source->getRegistry());
        $this->instances = array_merge($this->instances, $source->getInstances());

        return $this;
    }
}
