<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/30
 * Time: 13:32
 */
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;

class Tislogin{
    public function handle($request,\Closure $next){
        $tuijianren = Session::get('tuijianren');
        if (!$tuijianren) {
            return redirect('tuijianren/login');
        }
            return $next($request);

    }
}