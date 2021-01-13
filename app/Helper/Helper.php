<?php

namespace App\Helper;


class Helper
{
    public static function http_response($url, $status = null, $wait = 3)
    {
        if(! @ file_get_contents('https://goweatherforecast.com')){
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public static function SendMail($title, $email, $content, $content_email=[]){
        \Mail::send('content-email', $content_mail, function ($message) use ($email, $title, $content) {
            $message->from('tohweb@tohsoft.com', 'Tohsoft.com');
            $message->to($email)->subject($content);
        });
    }
}
