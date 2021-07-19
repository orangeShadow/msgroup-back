<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show_error_if_role_is_not($request, array $allow)
    {
        // Проверяем, кому разрешено использовать приложение, остальным возвращаем ошибку
        $user = $request->user();
        $role = config("roles.{$user->role}.name");
        if (!in_array($role, $allow)) abort(403, 'Этот функционал вам недоступен');
        return $role;
    }
}
