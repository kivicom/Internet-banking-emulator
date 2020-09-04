<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use App\UserAccount;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::where('id', $id)->first();
        $user_accounts = User::where('id', $id)->first()->user_account()->get();
        $currencies = UserAccount::CURRENCY_LIST;

        //dd($user);
        if (!$user){
            abort('404');
        }
        return view('profile.index', compact(['user','currencies','user_accounts','transactions']));
    }

}
