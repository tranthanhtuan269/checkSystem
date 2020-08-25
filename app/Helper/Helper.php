<?php

namespace App\Helper;


class Helper
{
    public static function http_response($url, $status = null, $wait = 3)
    {
        $fp = @fsockopen($url, $port=80, $errno, $errstr, 2);
        if (!$fp) {
            return 0;
        } else{
           return 1;
        }
    }

	public static function SendMail($title, $email, $content, $content_email=[]){
        \Mail::send('content-email', $content_mail, function ($message) use ($email, $title, $content) {
            $message->from('tohweb@tohsoft.com', 'Tohsoft.com');
            $message->to($email)->subject($content);
        });
    }
}
