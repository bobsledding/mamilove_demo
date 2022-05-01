<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{   
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public static function getRecentOrderCount(int $account_id)
    {
        $timestamp = Carbon::now()->subMinutes(5);

        return DB::table('orders')
            ->where('account', $account_id)
            ->where('created_at', '>=', $timestamps)
            ->count();
    }
}
