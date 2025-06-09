
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * ユーザーが認証されていない場合のリダイレクト先
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login.form');
        }
    }
}
