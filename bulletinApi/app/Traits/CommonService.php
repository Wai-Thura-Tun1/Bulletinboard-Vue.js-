<?php
namespace App\Traits;
trait CommonService
{
    public function createReponse($data, $message, $code,$key)
    {
        return response()->json([
            'message' => $message,
            $key => $data
        ], $code);
    }
}
