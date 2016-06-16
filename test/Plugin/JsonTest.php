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

use Es\ControllerPlugins\Plugin\Json;
use Es\Server\Server;
use Psr\Http\Message\ResponseInterface;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    public function toEncodeDataProvider()
    {
        return [
            ['Lorem ipsum dolor sit amet',         0, 1],
            [true,                                 0, 1],
            [false,                                0, 1],
            [100,                                  0, 1],
            [['foo' => 'bar'],                     0, 1],
            [(object) ['foo' => ['bar' => 'baz']], 0, 2],
        ];
    }

    /**
     * @dataProvider toEncodeDataProvider
     */
    public function testEncodeOnSuccess($data, $options, $depth)
    {
        $plugin = new Json();
        $server = new Server();
        $plugin->setServer($server);

        $result = $plugin->encode($data, $options, $depth);
        $this->assertInstanceOf(ResponseInterface::CLASS, $result);
        $this->assertArrayHasKey('Content-Type', $result->getHeaders());
        $encoded = (string) $result->getBody();
        $this->assertSame($encoded, json_encode($data, $options, $depth));
    }

    public function testEncodeRaiseExceptionOnFailure()
    {
        $data   = ['foo' => ['bar' => 'baz']];
        $plugin = new Json();
        $server = new Server();
        $plugin->setServer($server);
        $this->setExpectedException('RuntimeException');
        $plugin->encode($data, 0, 1);
    }

    public function toDecodeDataProvider()
    {
        return [
            [json_encode('Lorem ipsum dolor sit amet'), false, 1, 0],
            [json_encode(true),                         false, 1, 0],
            [json_encode(false),                        false, 1, 0],
            [json_encode(100),                          false, 1, 0],
            [json_encode(['foo' => 'bar']),             false, 2, 0],
            [json_encode(['foo' => 'bar']),             true,  2, 0],
        ];
    }

    /**
     * @dataProvider toDecodeDataProvider
     */
    public function testDecodeOnSuccess($json, $assoc, $depth, $options)
    {
        $plugin = new Json();

        $result = $plugin->decode($json, $assoc, $depth, $options);
        $this->assertEquals($result, json_decode($json, $assoc, $depth, $options));
    }

    public function testDecodeRaiseExceptionOnFailure()
    {
        $plugin = new Json();
        $this->setExpectedException('RuntimeException');
        $plugin->decode('foo');
    }
}
