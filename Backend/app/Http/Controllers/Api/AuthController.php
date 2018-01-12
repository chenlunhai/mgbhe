<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Exception;

use Illuminate\Support\Facades\Auth;

use App\User;

class AuthController extends Controller
{
    /**
     * 用户登录
     *
     * @return  \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (! $request->has('name')) {
            return response()->json(error_json('请输入账号'));
        }

        $name = $request->input('name');
        $name = preg_replace('/\s*/', '', $name);
        $password = $request->input('password');

        try {
            // 获取匹配查询条件的第一个模型
            $user = User::where('name', $name)->first();
            if (! $user) {
                // $user = User::create([
                //     'name' => $name,
                //     'password' => bcrypt($password),
                // ]);
                return response()->json(error_json('登录失败'));
            }
            Auth::login($user, true);
        } catch (Exception $e) {
            return response()->json(error_json('登录失败', $e->getCode()));
        }

        return response()->json(success_json('登录成功'));
    }
}
