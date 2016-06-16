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

use Es\Controllers\ControllersTrait;
use Es\Dispatcher\DispatchEvent;
use Es\Events\EventsTrait;
use InvalidArgumentException;

/**
 * Dispatch another controller.
 */
class Forward
{
    use ControllersTrait, EventsTrait;

    /**
     * Dispatch another controller.
     *
     * @param string $controller The controller name that is used in Controllers
     * @param string $action     Optional; name of the action without "Action" postfix
     * @param array  $params     Optional; event parameters
     *
     * @return mixed The dispatching result
     */
    public function __invoke($controller, $action = null, array $params = null)
    {
        if (! is_string($controller) || empty($controller)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid controller provided; must be a non-empty string, '
                . '"%s" received.',
                is_object($controller) ? get_class($controller)
                                       : gettype($controller)

            ));
        }
        if (null === $action) {
            $action = 'index';
        }
        if (! is_string($action) || empty($action)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid action provided; must be an null or a non-empty string, '
                . '"%s" received.',
                is_object($action) ? get_class($action) : gettype($action)
            ));
        }
        if (is_null($params)) {
            $params = [];
        }

        $events      = $this->getEvents();
        $controllers = $this->getControllers();
        $instance    = $controllers->get($controller);
        $event       = new DispatchEvent($instance, $controller, $action, $params);
        $events->trigger($event);

        return $event->getResult();
    }
}
