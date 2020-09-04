<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MoneyTransferController extends Controller
{
    public const BASE_CURRENCY = 'UAH';

    public function index(Request $request)
    {
        $payerAccount = $this->infoAccount($request->input('payerAccount'));
        $receiverAccount = $this->infoAccount($request->input('receiverAccount'));

        $payerSum = $request->input('payerSum');

        if (!$receiverAccount){
            return Redirect::back();
        }

        if ($payerSum > $payerAccount->amount){
            return Redirect::back();
        }


        $exchangerates = $this->currencyConveration($payerAccount->currency, $receiverAccount->currency, $payerSum);

        //dd($exchangerates);

        $payerAccount->amount = $payerAccount->amount - $payerSum;
        $receiverAccount->amount = $receiverAccount->amount + ($payerSum * $exchangerates);

        $payerAccount->save();
        $receiverAccount->save();

        $data = [
            'payerAccount' => $payerAccount,
            'receiverAccount' => $receiverAccount,
            'payerSum' => $payerSum,
        ];
        $this->transaction($data);

        return Redirect::back();
    }

    public function infoAccount($account)
    {
        $user_accounts = UserAccount::all()->where('account', $account)->first();
        return $user_accounts;
    }

    public function transaction($data)
    {
        //dd($data['payerAccount']['account']);
        return Transaction::create([
            'user_id_from' => $data['payerAccount']['user_id'],
            'user_id_to' => $data['receiverAccount']['user_id'],
            'account_from' => $data['payerAccount']['account'],
            'account_to' => $data['receiverAccount']['account'],
            'operation_code' => mt_rand(1000,9999),
            'type_of_operation' => 'Перевод средств да другой счет',
            'currency_from' => $data['payerAccount']['currency'],
            'currency_to' => $data['receiverAccount']['currency'],
            'amount' => $data['payerSum'],
        ]);
    }

    public function exchangeAPI()
    {
        // set POST variables
        $url 		= 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $result;
    }

    public function currencyConveration($from, $to, $amount)
    {
        $currencyCourse = $this->exchangeAPI();
        $exchangerates = [];
        if ($from === $to) {
            return 1;
        }

        foreach ($currencyCourse as $item){
            if ($to === self::BASE_CURRENCY){
                if ($item['ccy'] === $from){
                    return $item['buy'];
                }
            }
            if ($from === self::BASE_CURRENCY){
                if ($item['ccy'] === $to){
                    return $item['sale'];
                }
            }

            if ($to !== self::BASE_CURRENCY){
                if ($item['ccy'] === $from){
                    $exchangerates[$from] = $item['buy'];
                }
            }
            if ($from !== self::BASE_CURRENCY){
                if ($item['ccy'] === $to){
                    $exchangerates[$to] = $item['buy'];
                }
            }
        }
        return $exchangerates[$from] / $exchangerates[$to];
    }

}
