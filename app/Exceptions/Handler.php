<?php

namespace App\Exceptions;

use Acme\Point\Domain\Exception\DomainRuleException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as Res;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    private $responseFactory;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $translator;
    public function __construct(\Illuminate\Contracts\Routing\ResponseFactory $responseFactory, \Illuminate\Translation\Translator $translator)
    {
        $this->responseFactory = $responseFactory;
        $this->translator = $translator;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof DomainRuleException) {
            return $this->responseFactory->json(['message' => $this->translator->trans($exception->getMessage())], Res::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}
