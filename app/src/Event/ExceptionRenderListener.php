<?php
declare(strict_types=1);

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use App\Services\ExceptionRender\AlterMixerApiException;
use MixerApi\ExceptionRender\ErrorDecorator;

/**
 * Listens for the MixerApi.ExceptionRender.beforeRender event and calls AlterMixerApiException::decorate
 *
 * @package App\Event
 */
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
