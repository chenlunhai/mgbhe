<?php

/**
 * 2018-01-05
 */

if (! function_exists('success_json')) {
    function success_json($message, $data = '', $code = '')
    {
        $res = [
            'status' => 1,
            'msg' => $message,
        ];
        if ($data) {
            $res['data'] = $data;
        }
        $res['code'] = $code ?: 0;

        return $res;
    }
}

if (! function_exists('error_json')) {
    function error_json($message, $code = '', $data = '')
    {
        $res = [
            'status' => 0,
            'msg' => $message,
        ];
        $res['code'] = $code ?: 0;
        if ($data) {
            $res['data'] = $data;
        }

        return $res;
    }
}
