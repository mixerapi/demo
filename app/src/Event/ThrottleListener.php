<?php

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\ServerRequest;
use Muffin\Throttle\Middleware\ThrottleMiddleware;
use Muffin\Throttle\ValueObject\ThrottleInfo;

class ThrottleListener implements EventListenerInterface
{
    /**
     * @inheritDoc
     */
    public function implementedEvents(): array
    {
        return [
            ThrottleMiddleware::EVENT_GET_THROTTLE_INFO => 'getThrottleInfo',
        ];
    }

    /**
     * @param Event $event
     * @param ServerRequest $request
     * @param ThrottleInfo $throttle
     * @return void
     */
    public function getThrottleInfo(Event $event, ServerRequest $request, ThrottleInfo $throttle): void
    {
        if ($request->getUri()->getPath() === '/admin/auth/login') {
            $throttle->setLimit(60)->setPeriod(60)->appendToKey('auth_login');
        }
    }
}
