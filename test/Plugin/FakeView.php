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

use Es\Mvc\ViewInterface;
use Es\Mvc\ViewModelInterface;
use LogicException;

class FakeView implements ViewInterface
{
    public function setLayout(ViewModelInterface $layout)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function getLayout()
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function render(ViewModelInterface $model)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }
}
