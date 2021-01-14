<?php

namespace App\Helper;


class Helper
{
    public static function http_response($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
        $check_server = curl_exec($ch);
        curl_close($ch);

        if ($check_server) {
            return true;
        } else {
            return false;
        }
    }

	public static function SendMail($title, $email, $content, $content_email=[]){
        \Mail::send('content-email', $content_mail, function ($message) use ($email, $title, $content) {
            $message->from('tohweb@tohsoft.com', 'Tohsoft.com');
            $message->to($email)->subject($content);
        });
    }
}
