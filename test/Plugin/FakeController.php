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

use LogicException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FakeController
{
    public function indexAction(Request $request, Response $response)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }

    public function fakeAction(Request $request, Response $response)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }
}
