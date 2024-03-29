<?php

namespace AuthenticationApi\Controller;

use AuthenticationApi\Dto\JwkSetResponse;
use Cake\Event\EventInterface;
use MixerApi\JwtAuth\Jwk\JwkSetInterface;
use SwaggerBake\Lib\Attribute\OpenApiResponse;

class JwksController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event); // TODO: Change the autogenerated stub
        $this->Authentication->allowUnauthenticated(['index']);
    }

    /**
     * JWKS
     *
     * Returns a JSON Web Key Set.
     *
     * @param JwkSetInterface $jwkSet
     * @return void
     * @throws \Cake\Http\Exception\InternalErrorException
     */
    #[OpenApiResponse(schemaType: 'array', schema: JwkSetResponse::class)]
    public function index(JwkSetInterface $jwkSet)
    {
        $this->set('data', $jwkSet->getKeySet()['keys']);
        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
