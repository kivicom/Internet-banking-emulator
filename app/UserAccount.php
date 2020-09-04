<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'user_accounts';

    protected $fillable = [
        'user_id', 'currency', 'account', 'amount'
    ];

    public const CURRENCY_UAH = ['currency' => 'UAH', 'amount' => 5000];
    public const CURRENCY_USD = ['currency' => 'USD', 'amount' => 200];
    public const CURRENCY_EUR = ['currency' => 'EUR', 'amount' => 150];

    public const CURRENCY_LIST =
    [
        self::CURRENCY_UAH,
        self::CURRENCY_USD,
        self::CURRENCY_EUR
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
}
