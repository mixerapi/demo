<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\View\JsonView;
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\HalView\View\HalJsonView;
use MixerApi\JsonLdView\View\JsonLdView;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * @inheritdoc
     */
    public function viewClasses(): array
    {
        return [JsonCollectionView::class, JsonLdView::class, HalJsonView::class, JsonView::class];
    }
}
