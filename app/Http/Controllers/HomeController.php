<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use App\Website;
use App\Helper\Helper;

class HomeController extends Controller
{
    public function index(){
        $websites = Website::get();
        $obj_email = Email::first();

        foreach($websites as $website){
            if(Helper::http_response($website->link) == 1){
                $website->status = 1;
            }else{
                $website->status = 0;
            }
            
            $website->save();
        }

    	return view('home', ['email' => $obj_email, 'websites' => $websites]);
    }

    public function emails(){
        $emails = Email::get();
    	return view('email', ['emails' => $emails]);
    }

    public function addWeb(Request $request){
        if (strpos($request->link, 'http') == false) {
            $request->link = 'http://' . $request->link;
        }

        $website = new Website;
        $website->name = $request->name;
        $website->link = $request->link;
        $website->status = Helper::http_response($website->link);
        $website->save();

        return response()->json([
            'message' => 'OK',
            'status' => '201',
            'id_website' => $website->id,
            'status_website' => $website->status,
        ]);
    }

    public function addEmail(Request $request){
        $email = new Email;
        $email->email = $request->email;
        $email->save();

        return response()->json([
            'message' => 'OK',
            'status' => '201',
            'id' => $email->id,
            'email' => $email->email,
        ]);
    }

    public function updateEmail(Request $request){
        $email = Email::find($request->id);
        if($email){
            $email->email = $request->email;
            $email->save();
        }

        return response()->json([
            'message' => 'OK',
            'status' => '201',
        ]);
    }

    public function updateWebsite(Request $request){
        $website = Website::find($request->id);
        if($website){
            $website->name = $request->name;
            $website->link = $request->link;
            $website->save();
        }

        return response()->json([
            'message' => 'OK',
            'status' => '201',
        ]);
    }

    public function removeEmail(Request $request){
        $email = Email::find($request->id);
        if($email){
            $email->delete();
        }

        return response()->json([
            'message' => 'OK',
            'status' => '200',
        ]);
    }

    public function removeWeb(Request $request){
        $website = Website::find($request->id);
        if($website){
            $website->delete();
        }

        return response()->json([
            'message' => 'OK',
            'status' => '200',
        ]);
    }

    public function test(){
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];
       
        \Mail::to('tran.thanh.tuan269@gmail.com')->send(new \App\Mail\MyTestMail($details));
    }

    public function testSendMail(){
        try {
            $title = 'test';
            $emails = Email::where('id' ,'>' ,0)->pluck('email')->toArray();
            $content = 'Hệ thống xxx đang lỗi';
            $content_mail = ['system' => 'xxx2'];

            \Mail::send('content-email', $content_mail, function ($message) use ($emails, $title, $content) {
                $message->from('tohweb@tohsoft.com', 'Tohsoft.com');
                $message->to($emails)->subject($content);
            });
        } catch (\Exception $e) {
        }
    }
}
