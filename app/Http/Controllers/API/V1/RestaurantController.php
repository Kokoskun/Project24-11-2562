<?php
namespace App\Http\Controllers\API\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\IP;
class RestaurantController extends Controller{
	public function list(Request $request){
		try{
			$ip=(new IP())->getClientIP();
			if(empty($ip)){
				$queryIP='';
			}else{
				$queryIP='&locationbias='.$ip;
			}
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://maps.googleapis.com/maps/api/place/textsearch/json?query=restaurants+in+thai&key=".env('GOOGLE_MAP_KEY').$queryIP."&language=th&language%20=th",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"Accept: */*",
					"Cache-Control: no-cache",
					"Host: maps.googleapis.com",
					"cache-control: no-cache"
				),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if($err){
				return $err;
				return response()->json(['error' => 'unable_retrieve_information','alert'=>'ไม่สามารถดึงข้อมูลได้'],500);
			} else {
				return response()->json($response);
			}
		}catch(\Exception $e){
			return response()->json(['error' => 'bad_request','alert'=>'ข้อมูลที่ส่งมาพบข้อผิดพลาด'],400);
		}
	}
}