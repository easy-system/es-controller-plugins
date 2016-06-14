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

use Es\Mvc\ViewModelInterface;
use LogicException;

class FakeViewModel implements ViewModelInterface
{
    public function setContentType($type)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getContentType()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function setVariables($variables)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function addVariables($variables)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function setVariable($name, $value)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getVariables()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getVariable($name, $default = null)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function setModule($moduleName)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getModule()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function setTemplate($template)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getTemplate()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function setGroupId($id)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getGroupId()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function addChild(ViewModelInterface $child, $groupId = null)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getIterator()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function offsetExists($offset)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function offsetGet($offset)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function offsetSet($offset, $value)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function offsetUnset($offset)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function __set($name, $value)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function __get($name)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function __isset($name)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function __unset($name)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }
}
