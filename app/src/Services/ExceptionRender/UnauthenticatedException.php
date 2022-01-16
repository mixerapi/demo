<?php
declare(strict_types=1);

namespace App\Services\ExceptionRender;

use MixerApi\ExceptionRender\ErrorDecorator;

/**
 * An exception for unauthenticated requests. Informs users to use the demo api-key.
 *
 * @package App\Service\ExceptionRender
 */
class UnauthenticatedException implements ExceptionRenderInterface
{
    /**
     * @var ErrorDecorator
     */
    private $errorDecorator;

    /**
     * @param ErrorDecorator $errorDecorator
     * @return ErrorDecorator
     */
    public function __construct(ErrorDecorator $errorDecorator)
    {
        $this->errorDecorator = $errorDecorator;
    }

    /**
     * Modifies UnauthenticatedException
     *
     * @return ErrorDecorator
     */
    public function decorate(): ErrorDecorator
    {
        $viewVars = $this->errorDecorator->getViewVars();
        $viewVars['message'] = 'You must be authenticated. ';
        $viewVars['message'].= 'Use authentication header `API-KEY` with a value of `123` to authenticate.';

        return $this->errorDecorator->setViewVars($viewVars);
    }
}
