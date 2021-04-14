<?php
declare(strict_types=1);

namespace App\Service\ExceptionRender;

use MixerApi\ExceptionRender\ErrorDecorator;

interface ExceptionRenderInterface
{
    /**
     * @return ErrorDecorator
     */
    public function decorate(): ErrorDecorator;
}
