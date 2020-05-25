<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use App\User;
use App\Withdraw;
use App\Promo;
use App\Support;
use Carbon\Carbon;

class PagesController extends Controller
{
	const merchant_id = '';
	const merchant_secret_1 = ''; 
	const merchant_secret_2 = ''; 
	const YT_CHANCE = 80;
	
	public function pay(Request $request)
	{
		$amount = $request->amount; 
		$type = $request->payment_type; 
		if((int)$amount < 1){
			$amount = 99;
		}
		$int_id =  DB::table('payments')->insertGetId([
			'amount' => (int)$amount, 
			'user' => Auth::user()->id, 
			'time' => time(), 
			'timestamp' => Carbon::now(),
			'status' => 0,
			'type' => 0,
		]);
		$orderID = $int_id;

		$sign = md5(self::merchant_id.':'.$amount.':'.self::merchant_secret_1.':'.$orderID);
		if($type == 'qiwi'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=63';
		}else if($type == 'card'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=94';
		}else if($type == 'visa'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=94';
		}else if($type == 'mts'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=84';
		}else if($type == 'beeline'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=83';
		}else if($type == 'megafon'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=82';
		}else if($type == 'tele2'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=132';
		}else if($type == 'freekassa_skinpay'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=154';
		}else if($type == 'yandex'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=45';
		}else if($type == 'freekassa'){
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';
		}
		else
		{
			$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';
		}
		return redirect($url);
	}
	function getIP() 
	{
		if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
		return $_SERVER['REMOTE_ADDR'];
	}
	public function getPayment(Request $request)
	{

		$sign = md5(self::merchant_id.':'.$request->AMOUNT.':'.self::merchant_secret_2.':'.$request->MERCHANT_ORDER_ID);
		if($sign != $request->SIGN)
		{
			return "Signi neatbilst";
		}
		$payment = DB::table('payments')->where('id', $request->MERCHANT_ORDER_ID)->first();
		if(count($payment) == 0)
		{
			return "Neatrada bd";
		}
		else
		{
			if($payment->status != 0)
			{
				return "Status nav 0";
			}
			else
			{
				if($payment->amount != $request->AMOUNT)
				{
					return "Summa neatbilst";
				}
				else
				{
					$user = User::where('id', $payment->user)->first();
					$user->wallet = $user->wallet + $payment->amount;
					$user->deposit = $user->deposit + $payment->amount;
					$user->save();
					$te = User::where('ref_code', $user->ref_use)->first();
					if(count($te) == null || count($te) == 0)
					{

					}
					else
					{
						$bon = (5/100)*$payment->amount;
						$te->wallet =   $te->wallet + $bon;
						$te->save();
					}
					DB::table('payments')
					->where('id', $payment->id)
					->update(['status' => 1]);
					return 'success';
				}
			}
		}
	}	
	public function success()
	{
		return redirect('/');
	}
	public function stats()
	{
		$drops = DB::table('drops')->count();
		$users = DB::table('users')->count();
		return response()->json(['users' => $users,'drops' => $drops]);
	}
    public function index(Request $r)
	{
		if(isset($r->ref))
		{
			$r->session()->put('ref', $r->ref);
		}
		$cases = DB::table('cases')->get();
		foreach($cases as $c)
		{
			$total = DB::table('drops')->where('case_id', $c->id)->sum('drop_price');
			if($total == null)
			{
				$c->total = '0';
			}
			else
			{
				$c->total = $total;
			}
		}
		$users = DB::table('users')->orderBy('win', 'desc')->limit(10)->get();
		foreach($users as $u)
		{
			$u->count = DB::table('drops')->where('user_id', $u->id)->count();
		}
		return view('pages.index', compact('cases', 'users'));
	}
	public function faq()
	{
		return view('pages.faq');
	}
	public function garanties()
	{
		return view('pages.garanties');
	}
	public function terms()
	{
		return view('pages.terms');
	}
	public function support()
	{
		return view('pages.support');
	}
	public function bonus()
	{
		if(Auth::guest())
		{
			$count = 0;
		}
		else
		{
			$count = DB::table('users')->where('ref_use', Auth::user()->ref_code)->count();
		}
		return view('pages.bonus', compact('count'));
	}
	public function activebonus(Request $r)
	{
		if(isset($r->ref))
		{
			$has = DB::table('users')->where('ref_code', $r->ref)->first();
			if(!empty($has))
			{
				if($has->id == Auth::user()->id)
				{
					$r->session()->flash('your_ref_code', 'Вы не можете активировать свой код!');
					return redirect()->back();
				}
				$user = User::where('id', Auth::user()->id)->first();
				$user->ref_use = $r->ref;
				$user->wallet = $user->wallet + 10;
				$user->save();
				$payment = DB::table('payments')->insertGetId([
							'amount' => (int)10, 
							'user' => Auth::user()->id, 
							'time' => time(), 
							'timestamp' => Carbon::now(),
							'status' => 1,
							'type' => 1,
						]);
				$r->session()->flash('success_ref_code', 'Вы успешно активировали реф.код!');
				return redirect()->back();
			}
			else
			{
				$r->session()->flash('not_ref_code', 'Такого кода не найдено...');
				return redirect()->back();
			}
		}
		if(isset($r->get_quest))
		{
			$user = User::where('id', Auth::user()->id)->first();
			if($r->get_quest == 1)
			{
				$user->wallet = $user->wallet + 1;
				$user->level = 1;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 2)
			{
				$user->wallet = $user->wallet + 3;
				$user->level = 2;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 3)
			{
				$user->wallet = $user->wallet + 5;
				$user->level = 3;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 4)
			{
				$user->wallet = $user->wallet + 10;
				$user->level = 4;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 5)
			{
				$user->wallet = $user->wallet + 25;
				$user->level = 5;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 6)
			{
				$user->wallet = $user->wallet + 50;
				$user->level = 6;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 7)
			{
				$user->wallet = $user->wallet + 100;
				$user->level = 7;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 8)
			{
				$user->wallet = $user->wallet + 250;
				$user->level = 8;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 9)
			{
				$user->wallet = $user->wallet + 400;
				$user->level = 9;
				$user->save();
				return redirect('/bonus');
			}
			elseif($r->get_quest == 10)
			{
				$user->wallet = $user->wallet + 750;
				$user->level = 10;
				$user->save();
				return redirect('/bonus');
			}
		}
		if(isset($r->promo))
		{
			$code = Promo::where('code', $r->promo)->first();
			if(empty($code))
			{
				$r->session()->flash('not_code', 'Такого кода не существует!');
				return redirect()->back();
			}
			else
			{
				$user = User::where('id', Auth::user()->id)->first();
				$user->wallet = $user->wallet + $code->price;
				$user->save();
				Promo::where('id', $code->id)->delete();
				$r->session()->flash('success_code', 'Код успешно активирован!');
				return redirect()->back();
			}
		}
	}
	public function cases($id)
	{
		$case = DB::table('cases')->where('id', $id)->first();
		if($case == false)
		{
			abort('404');
		}
		$total = DB::table('drops')->where('case_id', $id)->sum('drop_price');
		if($total == null)
		{
			$case->total = '0';
		}
		else
		{
			$case->total = $total;
		}
		
		
		$type = DB::table('items')->where('case_id', $id)->where('type', 1)->get();
		if($case->price == 0)
		{
			$case->type = 1;
		}
		elseif(!empty($type))
		{
			$case->type = 2;
		}
		else
		{
			$case->type = 0;
		}
		
		
		
        $items = DB::table('items')->where('case_id', $id)->orderBy('price', 'asc')->get();
        $case->items = $items;
        $case->min = DB::table('items')->where('case_id', $id)->orderBy('price', 'asc')->first();
        $case->max = DB::table('items')->where('case_id', $id)->orderBy('price', 'desc')->first();
		return view('pages.case', compact('case'));
	}
	public function users($id)
	{
		$user = DB::table('users')->where('id', $id)->first();
		if($user == false)
		{
			abort('404');
		}
		else
		{
			$user->cases = DB::table('drops')->where('user_id', $user->id)->count();
			$user->sum = DB::table('drops')->where('user_id', $user->id)->sum('price');
			$l_d = DB::table('drops')->where('user_id', $user->id)->orderBy('id', 'desc')->limit(27)->get();
			foreach($l_d as $l)
			{
				$item = DB::table('items')->where('id', $l->item_id)->first();
				$l->image = $item->image;
			}
			$payments = DB::table('payments')->where('user', $user->id)->where('status', 1)->get();	
			$withdraws = DB::table('withdraw')->where('user_id', $id)->get();
			return view('pages.user', compact('user', 'l_d', 'payments', 'withdraws'));
		}
	}
	
	
	
	/*API*/
	public function get_rand(Request $r)
	{
		if(!isset($r->id) && !isset($r->user))
		{
			return 'Ne peredani parametri';
		}
		if(Auth::guest())
		{
			abort('404');
		}
		if(Auth::user()->id != $r->user)
		{
			return 'error1';
		}
		$case = DB::table('cases')->where('id', $r->id)->first();
		if($case->price == 0)
		{
			if(Auth::user()->bonus_time > Carbon::now())
			{
				return 'error_free';
			}
			$user = User::where('id', $r->user)->first();
			$user->bonus_time = Carbon::now()->addDays(1);
			$user->save();
			$prov = DB::table('drops')->where('user_id', Auth::user()->id)->where('price', '!=', 0)->get();
			if(empty($prov))
			{
				return 'error_not_normal_case';
			}				
		}
		if(Auth::user()->wallet < $case->price)
		{
			return 'error2';
		}
		$user = User::where('id', $r->user)->first();
		$user->wallet = $user->wallet - $case->price;
		$user->save();
		if(Auth::user()->is_yt == 0)
		{
			$chance = $case->chance;
		}
		else
		{
			$chance = self::YT_CHANCE;
		}
		
		$pro = mt_rand(1,100);
		if($pro > $chance)
		{
			$win = DB::table('items')->where('case_id',$r->id)->where('price','<',$case->price)->where('type', 0)->inRandomOrder()->first();
		}
		else
		{
			$win = DB::table('items')->where('case_id',$r->id)->where('price','>=',$case->price)->where('type', 0)->inRandomOrder()->first();
		}
		$win_id = $win->id;
		$drop_price = $win->price;
		$user = User::where('id', $r->user)->first();
		$user->wallet = $user->wallet + $win->price;
		$user->win = $user->win + $win->price;
		$user->save();
		$items = DB::table('items')->where('case_id', $r->id)->orderBy('price', 'asc')->get();

		foreach ($items as $index => $value) {
			if($value->id == $win_id)
			{
				$number = $index;
			}
		}
		$int_id =  DB::table('drops')->insertGetId([
                    'user_id' => $r->user,
                    'case_id' =>  $r->id,
                    'item_id' => $win_id,
					'price' => $case->price,
					'drop_price' => $drop_price,
					'time' => time()
                ]);
		return $number;
	}
	public function refresh_balance(Request $r)
	{
		if(!isset($r->id))
		{
			return;
		}
		$user = DB::table('users')->where('id', $r->id)->first();
		return $user->wallet;
	}
	public function get_drop()
	{
		$drops = DB::table('drops')->orderBy('id', 'desc')->limit(14)->get();
		foreach($drops as $d)
		{
			$item = DB::table('items')->where('id', $d->item_id)->first();
			$d->image = $item->image;
			$user = DB::table('users')->where('id', $d->user_id)->first();
			$d->ava = $user->avatar;
		}
		return view('api.get_drop', compact('drops'));
	}
	public function cashout(Request $r)
	{
		if(Auth::guest())
		{
			abort('404');
		}
		if(Auth::user()->steamid != $r->user_id)
		{
			return 'error1';
		}
		if(Auth::user()->wallet < $r->sum)
		{
			return 'error2';
		}
		if($r->sum < 100)
		{
			return 'error3';
		}
		if($r->wallet == '')
		{
			return 'error4';
		}
		$w = Withdraw::where('user_id', $r->user_id)->where('status', 0)->first();
		if(!empty($w))
		{
			return 'error5';
		}
		else
		{
			$user = User::where('id', Auth::user()->id)->first();
			$user->wallet = $user->wallet - $r->sum;
			$user->save();
			Withdraw::create([
				'user_id' => $r->user_id,
				'system' => $r->wallet_type,
				'wallet' => $r->wallet,
				'amount' => $r->sum,
				'date' => Carbon::now(),
				'status' => 0
			]);
			return 'success';
		}
	}
	public function refresh_opens(Request $r)
	{
		if(!isset($r->id))
		{
			return '0';
		}
		else
		{
			$count = DB::table('drops')->where('case_id', $r->id)->sum('drop_price');
			return $count;
		}
	}
	public function supports(Request $r)
	{
		if(Auth::guest())
		{
			return 'error1';
		}
		if(!isset($r->name) || !isset($r->email) || !isset($r->theme) || !isset($r->theme_text))
		{
			return 'error2';
		}
		if(strpos($r->email, '@') == false)
		{
			return 'error3';
		}
		if(Auth::user()->ban_support != 0)
		{
			return 'error5';
		}
		$has = Support::where('user_id', Auth::user()->id)->where('status',0)->first();
		if(!empty($has))
		{
			return 'error4';
		}
		else
		{
			Support::create([
				'user_id' => Auth::user()->id,
				'name' => $r->name,
				'email' => $r->email,
				'theme' => $r->theme,
				'theme_text' => $r->theme_text,
				'status' => 0
			]);
			return 'success';
		}
	}
	/*API*/
	public function test()
	{
		
	}
}
