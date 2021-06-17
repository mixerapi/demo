<?php
declare(strict_types=1);

namespace App\Service\ExceptionRender;

use MixerApi\ExceptionRender\ErrorDecorator;

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
        $viewVars['message'] = 'You must be authenticated for write operations. ';
        $viewVars['message'].= 'Use authentication header `API-KEY` with a value of `123` to authenticate.';

        return $this->errorDecorator->setViewVars($viewVars);
    }
}
