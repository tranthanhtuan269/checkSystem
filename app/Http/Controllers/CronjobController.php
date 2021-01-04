<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistical;
use Cache;

class CronjobController extends Controller
{
    public function saveVisited(){
        if (Cache::has('cache_visited')) {
            $cache_visited = Cache::get('cache_visited');
            Statistical::insert($cache_visited);
            Cache::forget('cache_visited');
        }
    }
}
