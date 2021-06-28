<?php
declare(strict_types=1);

namespace App\Service\ExceptionRender;

use MixerApi\ExceptionRender\ErrorDecorator;

/**
 * An interface for modifying exceptions
 *
 * @package App\Service\ExceptionRender
 */
interface ExceptionRenderInterface
{
    /**
     * @return ErrorDecorator
     */
    public function decorate(): ErrorDecorator;
}
