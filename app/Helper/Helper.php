<?php

namespace App\Helper;


class Helper
{
    public static function http_response($url, $status = null, $wait = 3)
    {
        $time = microtime(true);
        $expire = $time + $wait;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // dd("httpCode:" . $httpCode);
        // dd($status);
        dd($head);

        curl_close($ch);
        
        if(!$head)
        {
            return 0;
        }
        
        if($status === null)
        {
            if($httpCode < 400)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        elseif($status == $httpCode)
        {
            return 1;
        }
        
        return FALSE;
    }

	public static function SendMail($title, $email, $content, $content_email=[]){
        \Mail::send('content-email', $content_mail, function ($message) use ($email, $title, $content) {
            $message->from('tohweb@tohsoft.com', 'Tohsoft.com');
            $message->to($email)->subject($content);
        });
    }
}
