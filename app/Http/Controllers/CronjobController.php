<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistical;
use Cache;

class CronJobController extends Controller
{
    public function saveVisitedWebsite(){
        if (Cache::has('cache_visited')) {
            $cache_visited = Cache::get('cache_visited');

            if (count($cache_visited) > 0) {
                Statistical::insert($cache_visited);
                Cache::forget('cache_visited');
            } else {
                echo 'empty';
            }
        }
    }
}
