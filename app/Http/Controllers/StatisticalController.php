<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statistical;

class StatisticalController extends Controller
{
    public function show(Request $request){
        $type = $request->type;
        $type = $type > 0 ? $type : 1;
        $domain = $request->web;
        $data = file_get_contents('http://' . $domain . '/get-data-ajax-highchart?type=' . $type);
        return view('statistical.index', compact('data'));
    }

    public function getDataAjaxHighchart(Request $request){
        $type = $request->type;
        $type = $type > 0 ? $type : 1;
        $thisDay = $thisMonth = $thisYear = '';
        $data = [];

        if ($type == 1 || $type== 2) {
            if ($type== 1) { // Hôm nay
                $thisDay = date('Y-m-d');
            } else { 
                $thisDay = date('Y-m-d', strtotime("-1 day"));
            } 

            $data = Statistical::selectRaw('COUNT(id) as total, HOUR(created_at) as hour')->whereDate('created_at', $thisDay)->groupBy('hour')->pluck('total', 'hour')->toArray();
            // dd($data);
        } elseif ($type == 3 || $type== 4) {
            if ($type== 3) { // Tuần nay
                $date_from = date("Y-m-d", strtotime("monday this week"));
                $date_to = date("Y-m-d", strtotime("sunday this week"));
            } else {
                $date_from = date("Y-m-d", strtotime("last week monday"));
                $date_to = date("Y-m-d", strtotime("last sunday"));
            } 
            $date_from = $date_from . " 00:00:00";
            $date_to = $date_to . " 23:59:59";
            $arr = Statistical::selectRaw('COUNT(id) as total, DAY(created_at) as day')->whereBetween('created_at', [$date_from, $date_to])->groupBy('day')->pluck('total', 'day')->toArray();
            
            $period = new \DatePeriod(new \DateTime($date_from), new \DateInterval('P1D'), new \DateTime($date_to));

            foreach ($period as $date) {
                $tmp_day = $date->format("d");
                $tmp_day = (int)$tmp_day;

                if (!isset($arr[$tmp_day])) {
                    $data[] = ['day' => $tmp_day, 'value' => 0];
                } else {
                    $data[] = ['day' => $tmp_day, 'value' => $arr[$tmp_day]];
                }
            }
        } elseif ($type== 5 || $type== 6) {
            if ($type == 5) {  // Tháng này
                $thisMonth = date('m');
            } else {
                $thisMonth = date('m') - 1;
            } 

            $thisYear = ($thisMonth == 0) ? date('Y') - 1 : date('Y');
            $results = \DB::select("SELECT COUNT(id) as total, DAY(created_at) as day FROM Statisticals WHERE YEAR(created_at)=$thisYear AND MONTH(created_at)=$thisMonth GROUP BY DAY(created_at)");
            
            foreach ($results as $value) {
                $data[$value->day] = $value->total;
            } 
        } elseif ($type== 7 || $type== 8) {
            if ($type== 7) { // Năm nay
                $thisYear = date('Y');
            } else {
                $thisYear = date('Y') - 1;
            } 

            $results = \DB::select("SELECT COUNT(id) as total, MONTH(created_at) as month FROM Statisticals WHERE YEAR(created_at)=$thisYear GROUP BY MONTH(created_at)");

            foreach ($results as $value) {
                $data[$value->month] = $value->total;
            }
        } else { // Tùy chỉnh
            // $date_from = $date_from . " 00:00:00";
            // $date_from = $date_to . " 23:59:59";
            // $data = Statistical::selectRaw('COUNT(id) as total, DATE_FORMAT(created_at, "%d/%m/%Y") as day')->where('type', 1)->whereBetween('created_at', [$request->date_from, $request->date_to])->groupBy('created_at')->pluck('total', 'day')->toArray();
        }

        return response()->json(['status' => 200, 'data' => $data, 'month' => $thisMonth, 'year' => $thisYear]);
    }
}
