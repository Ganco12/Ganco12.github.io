<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Withdraw extends Model
{
    protected $table = 'withdraw';
	
	protected $fillable = ['user_id', 'system', 'wallet', 'amount', 'date', 'status'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
}
