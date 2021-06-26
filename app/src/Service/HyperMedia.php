<?php
declare(strict_types=1);

namespace App\Service;

use Cake\Datasource\EntityInterface;
use Cake\Http\ServerRequest;
use Cake\Http\ServerRequestFactory;

class HyperMedia
{
    /**
     * @var ServerRequest
     */
    private $request;

    /**
     * @param \Cake\Http\ServerRequest|null $request an instance of ServerRequest
     */
    public function __construct(?ServerRequest $request = null)
    {
        $this->request = $request ?? ServerRequestFactory::fromGlobals();
    }

    /**
     * Returns a HyperMedia link
     *
     * @param string $urlTemplate a URL template such as "/%s/actors/%s"
     * @param EntityInterface $entity the cakephp model/entity
     * @return string|null
     */
    public function getHref(string $urlTemplate, EntityInterface $entity): string
    {
        $pieces = explode('/', $this->request->getPath());
        array_shift($pieces);
        $plugin = strtolower(reset($pieces));

        if (!in_array($plugin, ['public','admin'])) {
            return '';
        }

        return sprintf($urlTemplate, $plugin, $entity->get('id'));
    }
}
