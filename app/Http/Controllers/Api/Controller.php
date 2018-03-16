<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    use Helpers;

    public function errorResponse(int $status_code, $message = null, int $code = 0)
    {
        throw new HttpException($status_code, $message, null, [], $code);

    }
}
