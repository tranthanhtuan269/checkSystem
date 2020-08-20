<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Email;
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
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
        $this->info('Demo:Cron Cummand Run successfully!');
    }
}
