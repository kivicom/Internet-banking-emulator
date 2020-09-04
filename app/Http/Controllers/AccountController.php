<?php

namespace App\Http\Controllers;

use App\UserAccount;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function create(Request $request)
    {
        if ($request->input('currency') == null){
            Session::flash('account_message', "Необходимо выбрать в какой валюте открыть счет");
            return Redirect::back();
        }
        $currency = $this->currency($request->input('currency'));
        $account = $this->get_accounts($request->input('user_id'), $currency['currency']);
        if ($account === true){
            Session::flash('account_message', "У Вас уже имеется счет в валюте {$currency['currency']}!");
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
        Session::flash('account_success', "Вы успешно создали счет в валюте {$currency['currency']}!");

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
