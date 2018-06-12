<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    public function errorResponse($status_code, $message = null, $code = 0)
    {
        throw new HttpException($status_code, $message, null, [], $code);
    }
}
