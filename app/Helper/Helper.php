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

	public static function send_mail($email, $content_mail, $title, $template) {
		$yandex = [
			'driver' => env('MAIL_DRIVER'),
			'host' => env('MAIL_HOST'),
			'port' => env('MAIL_PORT'),
			'username' => env('MAIL_USERNAME'),
			'password' => env('MAIL_PASSWORD'),
			'encryption' => env('MAIL_ENCRYPTION'),
		];
		$is_toh_email = ($email && mb_stripos($email, '@tohsoft.com') !== FALSE) ? TRUE : FALSE;
		if(!$is_toh_email){
			try {
				\Config::set('mail', $yandex);
				\Mail::send($template, $content_mail, function($message) use ($email, $title) {
					$message->from(env('MAIL_USERNAME'), 'TOH');
					$message->to($email)->subject($title);
				});
				$send_done = true;
			}catch(\Exception $e){

            }
		}
    }
}
