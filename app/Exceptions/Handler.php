<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    // apiのエラーハンドリング
    public function render($request, $exception)
    {
        /**
         * APIエラーの場合、apiErrorResponseをcall
         * WEBエラーの場合、ここでエラーハンドリングを完結する
         */
        if ($request->is('api/*')) {
            return $this->apiErrorResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }

    private function apiErrorResponse($request, $exception)
    {
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            switch ($statusCode) {
                case 400:
                    return response()->error(Response::HTTP_BAD_REQUEST, 'リクエストに不備があります');
                case 401:
                    return response()->error(Response::HTTP_UNAUTHORIZED, '入力された情報がログイン情報と一致しません。');
                case 403:
                    return response()->error(Response::HTTP_FORBIDDEN, 'アクセス権がありません。');
                case 404:
                    return response()->error(Response::HTTP_NOT_FOUND, 'ページが見つかりません。');
                case 419:
                    return ('ページの有効期限が切れています。再度読み込みしてください.');
                    break;
                case 429:
                    return ('サーバーへのリクエスト数が上限を超えています。再度ページの読み込みを行なってください。');
                    break;
                case 500:
                    return ('サーバーエラーが生じています。時間を空けて再度ページを読み込んでください・');
                    break;
                case 503:
                    return ('サーバーが処理できませんでした。時間を空けてアクセスしてください。');
                    break;
            }
        }
    }
}
