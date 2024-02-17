<?php
declare(strict_types=1);

namespace AdminApi\Controller;

use App\Controller\AppController as BaseController;
use Authentication\Controller\Component\AuthenticationComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property AuthenticationComponent $Authentication
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
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
