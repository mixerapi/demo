<?php
declare(strict_types=1);

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use App\Service\ExceptionRender\AlterMixerApiException;
use MixerApi\ExceptionRender\ErrorDecorator;

class ExceptionRenderListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'MixerApi.ExceptionRender.beforeRender' => 'beforeRender'
        ];
    }

    /**
     * @param Event $event
     * @throws \ReflectionException
     */
    public function beforeRender(Event $event)
    {
        /** @var ErrorDecorator $errorDecorator */
        $errorDecorator = $event->getSubject();
        $mixerException = $event->getData()['exception'];
        $errorDecorator = (new AlterMixerApiException($errorDecorator, $mixerException))->decorate();
    }
}
