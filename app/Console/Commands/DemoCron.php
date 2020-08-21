<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Email;
use App\Config;
use App\Website;
use App\Helper\Helper;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $config = Config::where('key', 'interval')->first();
        if($config){
            $diff_time=strtotime(date("Y/m/d H:i:s"))-strtotime($config->updated_at);
            switch ($config->value) {
                case '1':
                    if($diff_time % 60 == 0){
                        $this->checkAction();
                    }
                    break;
                case '2':
                    if($diff_time % 300 == 0){
                        $this->checkAction();
                    }
                    break;
                case '3':
                    if($diff_time % 600 == 0){
                        $this->checkAction();
                    }
                    break;
                case '4':
                    if($diff_time % 900 == 0){
                        $this->checkAction();
                    }
                    break;
                case '5':
                    if($diff_time % 1800 == 0){
                        $this->checkAction();
                    }
                    break;
                case '6':
                    if($diff_time % 3600 == 0){
                        $this->checkAction();
                    }
                    break;
                case '7':
                    if($diff_time % 10800 == 0){
                        $this->checkAction();
                    }
                    break;
                case '8':
                    if($diff_time % 21600 == 0){
                        $this->checkAction();
                    }
                    break;
                case '9':
                    if($diff_time % 43200 == 0){
                        $this->checkAction();
                    }
                    break;
                case '10':
                    if($diff_time % 86400 == 0){
                        $this->checkAction();
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
        $this->info('Demo:Cron Cummand Run successfully!');
    }

    public function checkAction(){

        \Log::info("Cron is working fine!");
        $websites = Website::get();

        foreach($websites as $website){
            if(Helper::http_response($website->link) == 1){
                $website->status = 1;
            }else{
                $website->status = 0;

                $title = 'test';
                $emails = Email::pluck('email')->toArray();
                $content = 'Hệ thống '. $website->name .' đang lỗi';
                $content_mail = ['system' => $website->name];

                \Mail::send('content-email', $content_mail, function ($message) use ($emails, $title, $content) {
                    $message->from('tohweb@tohsoft.com', 'Tohsoft.com');
                    $message->to($emails)->subject($content);
                });
            }
            
            $website->save();
        }

        \Log::info("Cron is working fine 2!");
    }
}
