<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use App\Config;
use App\Website;
use App\Statistical;
use App\Helper\Helper;

class HomeController extends Controller
{
    public function index(){
        $websites = Website::orderBy('id', 'DESC')->paginate(5);
        $obj_email = Email::first();

        foreach($websites as $website){
            if(Helper::http_response($website->link) == 1){
                $website->status = 1;
            }else{
                $website->status = 0;
            }
            
            $day_deploy_nearest = @file_get_contents($website->link . '/get-info-git-pull-nearest');

            if ($day_deploy_nearest == false || strlen($day_deploy_nearest) > 19) {
                $day_deploy_nearest = null;
            }

            $website->day_deploy = $day_deploy_nearest;
            $website->save();
        }
        
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
        $rules = [
            'name'          => 'required|max:255|unique:websites,name',
            'link'          => 'required|unique:websites,link',
            // 'day_deploy'          => 'required',
        ];
        $messages = [];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => '404',
                'errors' =>  $validator->errors(),
            ]);
        } else {
            if (strpos($request->link, 'http') === false) {
                $request->link = 'http://' . $request->link;
            }

            if (!empty($request->link_admin) && strpos($request->link_admin, 'http') === false) {
                $request->link_admin = 'http://' . $request->link_admin;
            }


            // $day_deploy_nearest = @file_get_contents($request->link . '/get-info-git-pull-nearest');

            // if ($day_deploy_nearest == false) {
            //     $day_deploy_nearest = null;
            // }
     
            $website = new Website;
            $website->name = $request->name;
            $website->link = $request->link;
            $website->link_admin = $request->link_admin;
            $website->day_deploy = null;
            // $website->day_deploy = $day_deploy_nearest;
            // $website->status = Helper::http_response($website->link);
            $website->save();
    
            return response()->json([
                'message' => 'OK',
                'status' => '200',
                // 'id_website' => $website->id,
                // 'name_website' => $website->name,
                // 'link_website' => $website->link,
                // 'day_deploy' => empty($day_deploy_nearest) ? '' : \Carbon\Carbon::parse($day_deploy_nearest)->format('d/m/Y H:i:s'),
                // 'link_admin' => $request->link_admin,
                // 'status_website' => $website->status,
            ]);
        }
    }

    public function updateWebsite(Request $request){
        $rules = [
            'name'          => 'required|max:255|unique:websites,name,'.$request->id,
            'link'          => 'required|unique:websites,link,'.$request->id,
            // 'day_deploy'          => 'required',
        ];
        $messages = [];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => '404',
                'errors' =>  $validator->errors(),
            ]);
        } else {
            
            if (strpos($request->link, 'http') === false) {
                $request->link = 'http://' . $request->link;
            }

            if (!empty($request->link_admin) && strpos($request->link_admin, 'http') === false) {
                $request->link_admin = 'http://' . $request->link_admin;
            }
            // dd($request->link);
            $website = Website::find($request->id);

            // $day_deploy_nearest = @file_get_contents($request->link . '/get-info-git-pull-nearest');

            // if ($day_deploy_nearest == false) {
            //     $day_deploy_nearest = null;
            // }

            if($website){
                $website->name = $request->name;
                $website->link = $request->link;
                $website->link_admin = $request->link_admin;
                // $website->day_deploy = $day_deploy_nearest;
                // $website->status = Helper::http_response($request->link);
                $website->save();
            }
    
            return response()->json([
                'message' => 'OK',
                'status' => '200',
                // 'status_website' => $website->status,
                // 'day_deploy' => empty($day_deploy_nearest) ? '' : \Carbon\Carbon::parse($day_deploy_nearest)->format('d/m/Y H:i:s'),
            ]);
        }
    }

    public function addEmail(Request $request){
        $rules = [
            'email'          => 'required|max:255|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"|unique:emails,email',
        ];
        $messages = [];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => '404',
                'errors' =>  $validator->errors(),
            ]);
        } else {
            $email = new Email;
            $email->email = $request->email;
            $email->save();
    
            return response()->json([
                'message' => 'OK',
                'status' => '200',
                'id' => $email->id,
                'email' => $email->email,
            ]);
        }
    }

    public function updateEmail(Request $request){
        $rules = [
            'email'          => 'required|max:255|regex_email:"/^[_a-zA-Z0-9-]{2,}+(\.[_a-zA-Z0-9-]{2,}+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/"|unique:emails,email,'.$request->id,
        ];
        $messages = [];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => '404',
                'errors' =>  $validator->errors(),
            ]);
        } else {
            $email = Email::find($request->id);
            if($email){
                $email->email = $request->email;
                $email->save();
            }
    
            return response()->json([
                'message' => 'OK',
                'status' => '200',
            ]);
        }
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
        dd(Helper::http_response('sadasdsadas.com'));
   }

   public function checkUrlIsset(Request $request){
        if(Helper::http_response($request->link) == 1){
            return response()->json([
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'status' => '404',
            ]);
        }
    }
}
