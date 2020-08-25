<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use App\Config;
use App\Website;
use App\Helper\Helper;

class HomeController extends Controller
{
    public function index(){
        $websites = Website::get();
        $obj_email = Email::first();
    	return view('home', ['email' => $obj_email, 'websites' => $websites]);
    }

    public function emails(){
        $emails = Email::get();
    	return view('email', ['emails' => $emails]);
    }

    public function settings(){
        $config = Config::where('key', 'interval')->first();
        return view('settings', ['config' => $config]);
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
            'name_website' => $website->name,
            'link_website' => $website->link,
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

    public function saveConfig(Request $request){
        $config = Config::where('key', 'interval')->first();
        if($config){
            $config->value = $request->setting;
            $config->updated_at = date("Y/m/d H:i:s");
            $config->save();
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
        dd(Helper::http_response("http://vidconverteronline.com"));
    }
}
