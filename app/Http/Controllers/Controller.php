<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helper\Helper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        if (!isset($_COOKIE['visited'])) {
            $postdata = http_build_query(
                array(
                    'web' => 'goweatherforecast.com',
                )
            );
            
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            
            $context  = stream_context_create($opts);
            file_get_contents('http://check-server/create-cache-visited', false, $context);
            setcookie($visited, "visited", time() + 86400);// 86400 = 1 day
        }
    }
}
