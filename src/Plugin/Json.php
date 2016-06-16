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

use Es\Server\ServerTrait;
use RuntimeException;

/**
 * The plugin implements the JSON data-interchange format.
 */
class Json
{
    use ServerTrait;

    /**
     * Encodes data and returns the response.
     *
     * @param mixed $data    The data to encode
     * @param int   $options The bitmask of options
     * @param int   $depth   The maximum depth
     *
     * @throws \RuntimeException If encoding fails
     *
     * @return \Psr\Http\Message\ResponseInterface The response
     */
    public function encode($data, $options = 0, $depth = 512)
    {
        $server   = $this->getServer();
        $response = $server->getResponse(false);
        $json     = json_encode($data, $options, $depth);
        if (false === $json) {
            throw new RuntimeException(
                json_last_error_msg(),
                json_last_error()
            );
        }
        $response->getBody()->write($json);
        $result = $response->withHeader(
            'Content-Type',
            'application/json;charset=utf-8'
        );

        return $result;
    }

    /**
     * Decodes json.
     *
     * @param string $json    The json string being decoded
     * @param bool   $assoc   When true, returned objects will be converted into
     *                        associative arrays
     * @param int    $depth   User specified recursion depth
     * @param int    $options Bitmask of JSON decode options
     *
     * @throws \RuntimeException If decoding fails
     *
     * @return mixed Returns the value encoded in json in appropriate PHP type
     */
    public function decode($json, $assoc = false, $depth = 512, $options = 0)
    {
        $result = json_decode((string) $json, (bool) $assoc, (int) $depth, (int) $options);
        if (null === $result && JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException(
                json_last_error_msg(),
                json_last_error()
            );
        }

        return $result;
    }
}
