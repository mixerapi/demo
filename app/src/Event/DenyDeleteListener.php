<?php
declare(strict_types=1);

namespace App\Event;

use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\Exception\MethodNotAllowedException;

/**
 * Listens for the MixerApi.ExceptionRender.beforeRender event and calls AlterMixerApiException::decorate
 *
 * @package App\Event
 */
class DenyDeleteListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            'Model.beforeDelete' => 'beforeDelete'
        ];
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     */
    public function beforeDelete(Event $event, EntityInterface $entity)
    {
        if (Configure::read('debug')) {
            return;
        }

        if (!$entity->has('modified')) {
            throw new MethodNotAllowedException(
                'Deletes on certain records are disabled n the public demo, try another.'
            );
        }

        if (Chronos::today()->diffInMonths($entity->get('modified'), false) < 0) {
            throw new MethodNotAllowedException(
                'You may only delete new records in the public demo. Try creating a record then deleting it.'
            );
        }
    }
}
