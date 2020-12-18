<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    private $statusCode = 200;

    /**
     * Set status code
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Standard response
     */
    protected function respond($data, $headers = [])
    {
        return response()->json($data, $this->statusCode, $headers);
    }

    /**
     * Empty success response
     */
    protected function respondSuccess()
    {
        return $this->setStatusCode(204)->respond(null);
    }

    /**
     * Failed operation
     */
    protected function respondFailed($message, $data = [])
    {
        return $this->setStatusCode(500)->respond([
            'message' => $message,
            'data' => $data
        ]);
    }
}
