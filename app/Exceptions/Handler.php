<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

// use Illuminate\Database\Eloquent\ModelNotFoundException;// copied to the trait
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; // copied to the trait
// use Symfony\Component\HttpFoundation\Response; // copied to the trait


class Handler extends ExceptionHandler
{
    use ExceptionTrait; //only if uses the exceptionTraitClass
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
        if($request->expectsJson()){
            
            /*
            if($exception instanceof ModelNotFoundException){
                return response()->json([
                    'errors' => "Product Model not found"
                ],Response::HTTP_NOT_FOUND);
            }

            if($exception instanceof NotFoundHttpException){
                return response()->json([
                    'errors' => "Incorect route"
                ],Response::HTTP_NOT_FOUND);
            }
            */
           
           return $this->apiException($request, $exception);
        }
        // dd($exception);
        return parent::render($request, $exception);
    }
}
