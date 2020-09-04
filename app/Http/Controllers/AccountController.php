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
        $account = $this->getAccounts($request->input('user_id'), $currency['currency']);
        if ($account === true){
            Session::flash('account_message', "У Вас уже имеется счет в валюте {$currency['currency']}!");
            return Redirect::back();
        }
        $account_number = $this->generateNumber();
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

    public function generateNumber()
    {
        $user_account = UserAccount::latest()->first();
        $account_number  = bcadd($user_account['account'], 1);
        if (!$user_account){
            $account_number = '1111111111111111';
        }
        return $account_number;
    }

    public function getAccounts($id, $currency)
    {
        $user_accounts = UserAccount::all()->where('user_id', $id);
        foreach ($user_accounts as $account){
            if ($account['currency'] == $currency){
                return true;
            }
        }
        return false;
    }

    public function chekSum($account)
    {
        $user_account = UserAccount::all()->where('account', $account)->first();
        return $user_account->amount;
    }

    public function destroy($id) {
        $user_account = UserAccount::find($id);

        if ($this->chekSum($user_account->account) > 0){
            Session::flash('user_account_delete_error', "На сету остались денежные средства, их необходимо перевести на другой счет!");
            return Redirect::back();
        }
        $user_account->delete();
        Session::flash('user_account_delete_success', "Вы успешно закрыли счет!");

        return Redirect::back();
    }
}
