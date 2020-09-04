<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index($id)
    {
        $users = User::all();
        $transactions = $this->getTransaction($id);
        if (!Auth::user()){
            abort('404');
        }

        return view('profile.transaction', compact(['users', 'transactions']));
    }

    public function getTransaction($id)
    {
        return Transaction::where('user_id_from', $id)->orWhere('user_id_to', $id)->get();
    }
}
