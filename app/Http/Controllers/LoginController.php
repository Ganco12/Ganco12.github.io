<?php
// POWERED BY HR https://vk.com/harisonwells THANK YOU FOR DOWNLOAD
// POWERED BY HR https://vk.com/harisonwells THANK YOU FOR DOWNLOAD


namespace App\Http\Controllers;

use Auth;
use Invisnik\LaravelSteamAuth\SteamAuth;
use App\User;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	private $steam;

    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }
    public function vklogin(Request $r)
    {
        $client_id = '6640061';
        $client_secret = 'DgWd4MitvTUrUiWZ8615';
        $redirect_uri = 'line-drop.ru';
        if (!is_null($r->code)) 
		{
			$obj = json_decode($this->curl('https://oauth.vk.com/access_token?client_id=' . $client_id . '&client_secret=' . $client_secret . '&redirect_uri=http://' . $redirect_uri . '/vklogin&code=' . $r->code));
			if (isset($obj->access_token))
			{
				$info = json_decode($this->curl('https://api.vk.com/method/users.get?user_ids&fields=photo_200&access_token=' . $obj->access_token . '&v=V'), true);
				$user = User::where('steamid', $info['response'][0]['uid'])->first();
				if($user == NULL) 
				{
					if(array_key_exists('photo_200', $info['response'][0]))
					{
						$photo = $info['response'][0]['photo_200'];
					}else
					{
						$photo = 'http://vk.com/images/camera_200.png';
					}
					if ($r->session()->has('ref')) {
						$has = DB::table('users')->where('ref_code', session('ref'))->first();
						if(!empty($has))
						{
							$ref_use = session('ref');
							$wallet = 10;
						}
						else
						{
							$ref_use = NULL;
							$wallet = 0;
						}
					}
					else
					{
						$ref_use = NULL;
						$wallet = 0;
					}
					$user = User::create([
						'username' => $info['response'][0]['first_name'] . ' ' . $info['response'][0]['last_name'],
						'avatar' => $photo,
						'wallet' => $wallet,
						'steamid' => $info['response'][0]['uid'],
					]);
					
				} 
				else 
				{
					if(array_key_exists('photo_200', $info['response'][0]))
					{
						$photo = $info['response'][0]['photo_200'];
					}
					else
					{
						$photo = 'http://vk.com/images/camera_200.png';
					}
					$user->username = $info['response'][0]['first_name'] . ' ' . $info['response'][0]['last_name'];
					$user->avatar = $photo;
					$user->steamid = $info['response'][0]['uid'];
					$user->save();
				}
				Auth::login($user, true);
				if(isset($ref_use))
				{
					if($ref_use != NULL)
					{
						$payment = DB::table('payments')->insertGetId([
							'amount' => (int)10, 
							'user' => Auth::user()->id, 
							'time' => time(), 
							'timestamp' => Carbon::now(),
							'status' => 1,
							'type' => 1,
						]);
					}
				}	
				return redirect('/games');
			}
		} 
		else 
		{
			return redirect('https://oauth.vk.com/authorize?client_id=' . $client_id . '&display=page&redirect_uri=http://' . $redirect_uri . '/vklogin&scope=friends,photos,status,offline,&response_type=code&v=5.53');
		}
	}

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function generate_name()
    {
        $length = 8;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public function generate()
    {
        $length = 13;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
	
	function secureoutput($string)
	{
    $string=htmlentities(strip_tags($string));
    $string=str_replace('>', '', $string);
    $string=str_replace('<', '', $string);
    $string=htmlspecialchars($string);
    return $string;
	}
}
