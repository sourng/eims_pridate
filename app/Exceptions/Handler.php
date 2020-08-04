<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }



        // if (Cookie::get('locale')) {
        //     $locale = Crypt::decryptString(Cookie::get('locale'));
        //     App::setLocale($locale);
        // }

        // if ($this->isHttpException($exception)) {

        //     if (method_exists($exception, 'getStatusCode')) {
        //         $statusCode = $exception->getStatusCode();
        //     } else {
        //         $statusCode = 500;
        //     }


        //     $response = [];

        //     switch ($statusCode) {
        //         case 401:
        //             $response['message'] = Translator::phrase('unauthorized');
        //             break;
        //         case 403:
        //             $response['message'] = Translator::phrase('Forbidden');
        //             break;
        //         case 404:
        //             $response['message'] = Translator::phrase('Not Found');
        //             break;
        //         case 405:
        //             $response['message'] = Translator::phrase('Method Not Allowed');
        //             break;
        //         case 422:
        //             $response['message'] = Translator::phrase($exception->original['message']);
        //             $response['errors'] = $exception->original['errors'];
        //             break;
        //         default:
        //             $response['message'] = ($statusCode == 500) ? 'Whoops, looks like something went wrong' : $exception->getMessage();
        //             break;
        //     }

        //     $response['success'] = false;
        //     $response['status'] = $statusCode;

        //     if (config('app.debug')) {

        //         if($request->ajax()){
        //             $response['trace'] = $exception->getTrace();
        //             $response['code'] = $exception->getCode();
        //             return response()->json($response, $statusCode);
        //         }else{
        //             return parent::render($request, $exception);
        //         }

        //     } elseif ($request->ajax()) {
        //         return response()->json($response, $statusCode);
        //     } else {
        //         return response()->view('errors.' . $statusCode, [], $statusCode);
        //     }
        // }

        return parent::render($request, $exception);
    }
}
