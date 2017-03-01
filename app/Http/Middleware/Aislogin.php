<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/30
 * Time: 14:13
 */
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;

class Aislogin
{
    public function handle($request, \Closure $next)
    {
        $admin = Session::get('admin');
        if (!$admin) {
            return redirect('tuiguangadmin');
        }
        return $next($request);
    }
}