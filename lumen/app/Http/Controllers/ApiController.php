<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    private $statusCode = 200;

    /*
    * set status code
    */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /*
    * standard response
    */
    protected function respond($data, $headers = [])
    {
        return response()->json($data, $this->statusCode, $headers);
    }

    /*
    * empty success response
    */
    protected function respondSuccess()
    {
        return $this->setStatusCode(204)->respond(null);
    }

    /*
    * failed operation
    */
    protected function respondFailed($message, $data = [])
    {
        return $this->setStatusCode(500)->respond([
            'message' => $message,
            'data' => $data
        ]);
    }
}
