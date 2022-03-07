<?php

namespace App\Helper;

class IPChecker{

    public static function isIPOnline($ip){

        switch (SELF::currentOS()){
            case "windows":
                $arg = "n";
                break;
            case "linux":
                $arg = "c";
                break;
            default: throw new \Exception('unknown OS');
        }

        $result = "";
        $output = [];
        // to debug errors add 2>&1 to the command to fill $output
        // https://stackoverflow.com/questions/16665041/php-why-isnt-exec-returning-output
        exec("ping -$arg 2 $ip " , $output, $result);
        // if 0 then the there is no errors like "Destination Host Unreachable"
        if ($result === 0) return true;
        return false;
    }


    public static function currentOS(){
        if(strpos(strtolower(PHP_OS), "win") !== false) return 'windows';
        elseif (strpos(strtolower(PHP_OS), "linux") !== false) return 'linux';
        //TODO: extend other OSs here
        else return 'unknown';

    }

}