<?php namespace Delivered\Helpers;

class ResponseHelper {

    public function error($errorMessages = [])
    {
        return response()->json(['success' => false, 'errors' => $errorMessages]);
    }

    public function success($data)
    {
        return response()->json(['success' => true, 'data' => $data]);
    }

}