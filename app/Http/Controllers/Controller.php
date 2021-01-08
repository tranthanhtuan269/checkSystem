<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helper\Helper;
use Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        Cache::rememberForever('cache_visited', function () {
            return [];
        });

        $cache_visited = Cache::get('cache_visited');
        
        if (!isset($_COOKIE['cache_visited'])) {
            $cache_visited[]= ['created_at' => date('Y-m-d H:i:s')];
            Cache::put('cache_visited', $cache_visited);
            setcookie('cache_visited', "visited", time() + 86400 );// 1 day
        }
    }
}
