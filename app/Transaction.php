<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'user_id_from', 'user_id_to', 'account_from',
        'account_to','operation_code', 'type_of_operation',
        'currency_from', 'currency_to', 'amount'
    ];
}
