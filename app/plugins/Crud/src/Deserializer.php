<?php
declare(strict_types=1);

namespace Crud;

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Utility\Xml;

class Deserializer
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(?Response $response = null)
    {
        $this->response = $response ?? new Response();
    }

    /**
     * Deserializes the request body
     *
     * @param ServerRequest $request
     * @return array
     */
    public function deserialize(ServerRequest $request): array
    {
        if ($this->response->mapType($request->contentType()) === 'xml') {
            $array = Xml::toArray(Xml::build((string)$request->getBody()));

            if (empty($array)) {
                throw new BadRequestException('Xml payload is empty');
            }

            $keys = array_keys($array);
            $node = reset($keys);

            if (!isset($array[$node]) || empty($array[$node])) {
                throw new BadRequestException('Xml payload is empty');
            }

            return $array[$node];
        }

        return $request->getData();
    }
}
