<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        // Проверка на наличие параметра dbg в запросе
//        if ($request->has('dbg')) {
//            // Запуск XHProf
//            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
//        }
//
//        return $next($request);
    }

    /**
     * Terminate the request handling.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     */
    public function terminate($request, $response)
    {
        // Проверка на наличие параметра dbg в запросе
//        if ($request->has('dbg')) {
            // Остановка XHProf и сохранение данных профилирования
//            $data = xhprof_disable();
//            include_once 'xhprof_lib/utils/xhprof_lib.php';
//            include_once 'xhprof_lib/utils/xhprof_runs.php';
//            $xhprof_runs = new \XHProfRuns_Default();
//            $xhprof_runs->save_run($data, 'xhprof_app');
//        }
    }
}
