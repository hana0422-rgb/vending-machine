<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginApiController extends Controller
{
   public function login(Request $request)
{
    // バリデーション
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 認証試行
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => '認証に失敗しました'], 401);
    }

    // 認証成功 → メッセージ返却
    return response()->json(['message' => 'ログイン成功']);
}
}
