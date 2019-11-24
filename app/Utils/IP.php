<?php
namespace App\Utils;
class IP{
	public function getClientIP(){
		if(isset($_SERVER['HTTP_CLIENT_IP']))
			return explode(',',$_SERVER['HTTP_CLIENT_IP'])[0];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			return explode(',',$_SERVER['HTTP_X_FORWARDED_FOR'])[0];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			return explode(',',$_SERVER['HTTP_X_FORWARDED'])[0];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			return explode(',',$_SERVER['HTTP_FORWARDED_FOR'])[0];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			return explode(',',$_SERVER['HTTP_FORWARDED'])[0];
		else if(isset($_SERVER['REMOTE_ADDR']))
			return explode(',',$_SERVER['REMOTE_ADDR'])[0];
		else
			return null;
	}
}