<?php

if (!function_exists('convertJsonToArray')) {
    function convertJsonToArray($data, $toArray = false)
    {
        return json_decode($data, $toArray);
    }
}
if (!function_exists('jsonResponse')) {
    function jsonResponse($result, $statusCode,$errorMsg = null)
    {
        $data['result'] = $result;
        $data['error'] = $errorMsg;
        return response()->json($data,$statusCode);
    }
}