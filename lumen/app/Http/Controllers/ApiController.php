<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    private $status_code;
    protected $user;

    public function __construct()
    {
        // Default values
        $this->$status_code = 200;

        // Get requesting user
        try {
            $this->user = Auth::userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            $this->user = null;
        }
    }

    /**
     * Set status code
     */
    protected function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

    /**
     * Standard response
     */
    protected function response($data, $headers = [])
    {
        return response()->json($data, $this->status_code, $headers);
    }

    /**
     * Success response
     */
    protected function responseSuccess($data = null)
    {
        return $this->setStatusCode(200)->response($data);
    }

    /**
     * Not found response
     */
    protected function responseNotFound($item = "item")
    {
        return $this->setStatusCode(404)->response($item . " not found");
    }

    /**
     * Duplicate response
     */
    protected function responseDuplicate()
    {
        return $this->setStatusCode(409)->response("duplicate entry");
    }

    /**
     * Failed operation
     */
    protected function responseFailed($message, $data = [])
    {
        return $this->setStatusCode(500)->response([
            'message' => $message,
            'data' => $data
        ]);
    }
}
