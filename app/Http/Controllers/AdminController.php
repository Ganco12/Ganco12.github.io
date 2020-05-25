<?php namespace App\Http\Controllers;

use App\User;
use App\Cases;
use App\Items;
use App\Withdraw;
use App\Promo;
use App\Support;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function index()
    {
		$user_money = \DB::table('users')->where('wallet', '!=', 0)->sum('wallet');
		$user_today = \DB::table('users')->where('created_at', '>=', Carbon::today())->count();
		$pay_today = \DB::table('payments')->where('created_at', '>=', Carbon::today())->where('status', 1)->where('type', 0)->sum('amount');
		$pay_week = \DB::table('payments')->where('created_at', '>=', Carbon::now()->subDays(7))->where('type', 0)->where('status', 1)->sum('amount');
		$pay_month = \DB::table('payments')->where('created_at', '>=', Carbon::now()->subDays(30))->where('status', 1)->where('type', 0)->sum('amount');
		$pay_all = \DB::table('payments')->where('status', 1)->where('type', 0)->sum('amount');
		
		if(!$user_money) $user_money = 0;
		if(!$user_today) $user_today = 0;
		if(!$pay_today) $pay_today = 0;
		if(!$pay_week) $pay_week = 0;
		if(!$pay_month) $pay_month = 0;
		if(!$pay_all) $pay_all = 0;

		return view('admin.index', compact('user_money', 'user_today', 'opened_today', 'pay_today', 'pay_week', 'pay_month', 'pay_all')); 
    }
	
	public function users()
    {
		$users = User::get();
		return view('admin.pages.users', compact('users')); 
    }
	
	public function edit_user($id)
    {
		return view('admin.includes.modal_users', ['user' => User::findOrFail($id)]);
    }
	public function edit_withdraw($id)
	{
		
		$user = \DB::table('withdraw')->where('id', $id)->first();
		$user->user = User::where('id', $user->user_id)->first();
		return view('admin.includes.modal_withdrows', compact('user'));
	}
	public function withdraw_save(Request $r)
	{
		if($r->get('status') == 0 || $r->get('status') == 1)
		{
			Withdraw::where('id', $r->get('id'))->update([
				'status' => $r->get('status')
			]);
		}
		elseif($r->get('status') == 2)
		{
			$withdraw = Withdraw::where('id', $r->get('id'))->first();
			$user = User::where('id', $withdraw->user_id)->first();
			$user->money = $user->money + $withdraw->amount;
			$user->save();
			$withdraw->status = 2;
			$withdraw->save();
		}
		$r->session()->flash('alert-success', 'Статус выплаты обновлен!');
		return redirect()->back();
	}
	
	public function item_add($id)
    {
		return view('admin.includes.modal_item_add', ['case' => Cases::findOrFail($id)]);
    }
	
	public function item_edit($id)
    {
		return view('admin.includes.modal_item_edit', ['item' => Items::findOrFail($id)]);
    }
	
	public function item_create(Request $r) {     
        Items::create([
            'name' => $r->get('name'),
            'image' => $r->get('image'),
            'price' => $r->get('price'),
			'case_id' => $r->get('id'),
            'type' => $r->get('type')
        ]);
		
		$r->session()->flash('alert-success', 'Предмет добавлен!');
        return redirect()->back();
    }
	
	public function item_update(Request $r) {     
        Items::where('id', $r->get('id'))->update([
             'name' => $r->get('name'),
            'image' => $r->get('image'),
            'price' => $r->get('price'),
			'case_id' => $r->get('id'),
            'type' => $r->get('type')
        ]);
		
		$r->session()->flash('alert-success', 'Предмет обновлен!');
        return redirect()->back();
    }
	
	public function user_save(Request $r) 
	{     
        User::where('id', $r->get('id'))->update([
            'wallet' => $r->get('money'),
            'is_admin' => $r->get('is_admin'),
            'rank' => $r->get('is_yt')
        ]);
		
		$r->session()->flash('alert-success', 'Настройки пользователя сохранены!');
        return redirect()->route('users');
    }
	public function ban_user($id, Request $r)
	{
		$user = User::where('id', $id)->first();
		$user->ban_support = 1;
		$user->save();
		$r->session()->flash('alert-success', 'Пользователь успешно забанен!');
        return redirect()->back();
	}
	public function new_case()
    {
		return view('admin.pages.new_case'); 
    }
	
	public function case_edit($id)
    {
		$case = Cases::where('id', $id)->first();
		$items = Items::where('case_id', $id)->get();
		
		$item = Items::where('case_id', $id)->get();
		
		return view('admin.pages.edit_case', compact('case', 'items', 'item'));
    }
	
	public function add_case(Request $r) {     
        Cases::create([
			'name' => $r->get('name'),
            'price' => $r->get('price'),
            'chance' => $r->get('chance'),
            'image' => $r->get('image')
        ]);
		
		$r->session()->flash('alert-success', 'Вы создали новый кейс!');
        return redirect()->route('cases');
    }
	
	public function case_update(Request $r) {     
        Cases::where('id', $r->get('id'))->update([
            'name' => $r->get('name'),
            'price' => $r->get('price'),
            'chance' => $r->get('chance')
        ]);
		
		$r->session()->flash('alert-success', 'Вы обновили кейс!');
        return redirect()->route('cases');
    }
	
	public function case_delete($id, Request $r) {
		Cases::where('id', $id)->delete();
		Items::where('case_id', $id)->delete();
		
		$r->session()->flash('alert-success', 'Кейс удален!');
        return redirect()->route('cases');
	}
	
	public function item_delete($id, Request $r) {
		Items::where('id', $id)->delete();
		
		$r->session()->flash('alert-success', 'Предмет удален!');
        return redirect()->back();
	}
	
	public function cases() {
		$cases = Cases::get();
		return view('admin.pages.cases', compact('cases')); 
    }

	
	public function withdraw()
    {
		$withdrows = Withdraw::get();
		foreach($withdrows as $w)
		{
			$user = \DB::table('users')->where('id', $w->user_id)->first();
			$w->user = $user;
			$date = $w->date;
			$w->dfh = Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
			//$w->dfh = $date->diffForHumans();
		}
		return view('admin.pages.withdraw', compact('withdrows')); 
    }
	
	public function payments()
	{
		$a = \DB::table('payments')->orderBy('id', 'desc')->where('status', 1)->where('type', 0)->take(20)->get();
		foreach ($a as $b) {
			$u = User::find($b->user);
			$b->name = $u->username;
			$b->name_id = $u->id;
		}
		return view('admin.pages.payments', compact('a'));
	}
	public function promocodes()
	{
		$a = \DB::table('promocodes')->get();
		return view('admin.pages.promocodes', compact('a'));
	}
	public function createpromo(Request $r)
	{
		if(!isset($r->amount) || !isset($r->count))
		{
			$r->session()->flash('alert-success', 'Не введены параметры!');
			return redirect()->back();
		}
		else
		{
			$count = $r->count;
			for ($i = 1; $i <= $count; $i++) {
				$user = Promo::create([
					'code' => $this->generate(),
					'price' => $r->amount
				]);
			}
			$r->session()->flash('alert-success', 'Промо-коды успешно созданы!');
			return redirect()->back();
		}
	}
	
	public function sup()
	{
		$a = \DB::table('support')->where('status', 0)->get();
		foreach($a as $b)
		{
			$user = User::where('id', $b->user_id)->first();
			$b->username = $user->username;
			$b->avatar = $user->avatar;
			$b->login = $user->login;
			$b->ban = $user->ban_support;
		}
		return view('admin.pages.support', compact('a'));
	}
	public function sup_close($id, Request $r)
	{
		$support = Support::where('id', $id)->first();
		$support->status = 1;
		$support->save();
		$r->session()->flash('alert-success', 'Тикет успешно закрыт!');
        return redirect()->back();
	}
	
	public function getBalans_frw() {
		$data = array(
			'wallet_id' => $this->config->fk_wallet,
			'sign' => md5($this->config->fk_wallet.$this->config->fk_api),
			'action' => 'get_balance',
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://wallet.free-kassa.ru/api_v1.php');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($result, true);

		if(!$json['status']) return;

		return $json['data']['RUR'];
    } 
	public function generate()
    {
        $length = 15;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}