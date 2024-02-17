<?php
declare(strict_types=1);

namespace AuthenticationApi\Controller;

use App\Controller\AppController as BaseController;
use Authentication\Controller\Component\AuthenticationComponent;

/**
 * @property AuthenticationComponent $Authentication
 */
class AppController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }
}
