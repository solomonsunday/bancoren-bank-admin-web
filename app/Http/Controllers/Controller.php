<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendBadRequestResponse($errors)
    {
        return response()->json([
            "message" => "Invalid user request",
            "errors" => $errors,
            "status" => 0,
            "status_code" => 400,
        ], 400);
    }


    protected function sendSuccessResponse($message, $data = [])
    {
        $response = [
            "message" => $message,
            "status" => 1,
            "status_code" => 200,
        ];
        if ($data)
            $response["data"] = $data;

        return response()->json($response);
    }

    protected function sendNotFoundResponse($message, $data = [])
    {
        $response = [
            "message" => $message,
            "status" => 0,
            "status_code" => 404,
        ];
        if (count($data))
            $response["data"] = $data;

        return response()->json($response, 404);
    }

    protected function sendUnAuthorisedResponse($message = "Unauthorised request")
    {
        $response = [
            "message" => $message,
            "status" => 0,
            "status_code" => 401,
        ];
        return response()->json($response, 401);
    }



}
