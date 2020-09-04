<?php

namespace App\Http\Controllers;

use App\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function create(Request $request)
    {
        if ($request->input('currency') == null){
            return Redirect::back();
        }
        $currency = $this->currency($request->input('currency'));
        $account = $this->get_accounts($request->input('user_id'), $currency['currency']);
        if ($account === true){
            return Redirect::back();
        }
        $account_number = $this->account();
        //dd($account_number);
        $userAccount = UserAccount::create([
            'user_id' => $request->input('user_id'),
            'currency' => $currency['currency'],
            'amount' => $currency['amount'],
            'account' => $account_number,
        ]);

        return Redirect::back();
    }

    public function currency($currency)
    {
        $currencies = UserAccount::CURRENCY_LIST;
        $curr = 'null';
        $amount = 'null';
        foreach ($currencies as $i => $curr){
            if($curr['currency'] == $currency){
                return $curr;
            }
        }
        return false;
    }

    public function account()
    {
        $user_account = UserAccount::latest()->first();
        $account_number  = bcadd($user_account['account'], 1);
        if (!$user_account){
            $account_number = '1111111111111111';
        }
        return $account_number;
    }

    public function get_accounts($id, $currency)
    {
        $user_accounts = UserAccount::all()->where('user_id', $id);
        foreach ($user_accounts as $account){
            if ($account['currency'] == $currency){
                return true;
            }
        }
        return false;
    }
}
