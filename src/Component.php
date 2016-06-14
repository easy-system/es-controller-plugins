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

use Es\Component\ComponentInterface;
use Es\Modules\ModulesEvent;

/**
 * The system component.
 */
class Component implements ComponentInterface
{
    /**
     * The configuration of services.
     *
     * @var array
     */
    protected $servicesConfig = [
        'ControllerPlugins' => 'Es\ControllerPlugins\ControllerPlugins',
    ];

    /**
     * The configuration of listeners.
     *
     * @var array
     */
    protected $listenersConfig = [
        'Es.ControllerPlugins.Listener.ConfigurePluginsListener' => 'Es\ControllerPlugins\Listener\ConfigurePluginsListener',
    ];

    /**
     * The configuration of events.
     *
     * @var array
     */
    protected $eventsConfig = [
        'ConfigurePluginsListener::__invoke' => [
            ModulesEvent::APPLY_CONFIG,
            'Es.ControllerPlugins.Listener.ConfigurePluginsListener',
            '__invoke',
            3000,
        ],
    ];

    /**
     * The configuration of system.
     *
     * @var array
     */
    protected $systemConfig = [
        'controller_plugins' => [
            'forward'  => 'Es\ControllerPlugins\Plugin\Forward',
            'json'     => 'Es\ControllerPlugin\Plugin\Json',
            'layout'   => 'Es\ControllerPlugins\Plugin\Layout',
            'redirect' => 'Es\ControllerPlugins\Plugin\Redirect',
            'url'      => 'Es\ControllerPlugins\Plugin\Url',
        ],
    ];

    /**
     * The current version of component.
     *
     * @var string
     */
    protected $version = '0.1.0';

    /**
     * Gets the current version of component.
     *
     * @return string The version of component
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Gets the configuration of services.
     *
     * @return array The configuration of services
     */
    public function getServicesConfig()
    {
        return $this->servicesConfig;
    }

    /**
     * Gets the configuration of listeners.
     *
     * @return array The configuration of listeners
     */
    public function getListenersConfig()
    {
        return $this->listenersConfig;
    }

    /**
     * Gets the configuration of events.
     *
     * @return array The configuration of events
     */
    public function getEventsConfig()
    {
        return $this->eventsConfig;
    }

    /**
     * Gets the configuration of system.
     *
     * @return array The configuration of system
     */
    public function getSystemConfig()
    {
        return $this->systemConfig;
    }
}
