<?php
declare(strict_types=1);

namespace App\Service\ExceptionRender;

use MixerApi\ExceptionRender\ErrorDecorator;
use MixerApi\ExceptionRender\MixerApiExceptionRenderer;
use ReflectionClass;

/**
 * Modifies MixerApi exception messages based on key-value pair in self::MAPPING
 *
 * @package App\Service\ExceptionRender
 */
class AlterMixerApiException
{
    /**
     * @var ErrorDecorator
     */
    private $errorDecorator;

    /**
     * @var MixerApiExceptionRenderer
     */
    private $renderer;

    private const MAPPING = [
        'Authentication\Authenticator\UnauthenticatedException' => UnauthenticatedException::class
    ];

    /**
     * @param ErrorDecorator $errorDecorator
     * @param MixerApiExceptionRenderer $renderer
     */
    public function __construct(ErrorDecorator $errorDecorator, MixerApiExceptionRenderer $renderer)
    {
        $this->errorDecorator = $errorDecorator;
        $this->renderer = $renderer;
    }

    /**
     * Calls exception handler based on MAPPING constants key-value association
     *
     * @return ErrorDecorator
     * @throws \ReflectionException
     */
    public function decorate(): ErrorDecorator
    {
        $fqn = get_class($this->renderer->getError());
        if (!$fqn) {
            return $this->errorDecorator;
        }

        if (!array_key_exists($fqn, self::MAPPING)) {
            return $this->errorDecorator;
        }

        $reflected = new ReflectionClass(self::MAPPING[$fqn]);
        if (!$reflected->implementsInterface(ExceptionRenderInterface::class)) {
            return $this->errorDecorator;
        }

        /** @var ExceptionRenderInterface $exceptionRender **/
        $exceptionRender = self::MAPPING[$fqn];

        return (new $exceptionRender($this->errorDecorator))->decorate();
    }
}
