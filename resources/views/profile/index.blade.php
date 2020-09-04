@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Профиль пользователя</h3></div>

                    <div class="card-body">
                        @if (session('profile'))
                            <div class="alert alert-success" role="alert">
                                {{ session('profile') }}
                            </div>
                        @endif

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Имя: {{$user->name}}</label>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email: {{$user->email}}</label>
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-primary">
                                            Счет в валюте UAH
                                        </li>
                                        @foreach($user_accounts as $user_account)
                                            @if($user_account->currency == 'UAH')
                                            <li class="list-group-item">
                                                №: {{$user_account->account}} Сумма: {{$user_account->amount}}
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="col-md-3">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-primary">
                                            Счет в валюте USD
                                        </li>
                                        @foreach($user_accounts as $user_account)
                                            @if($user_account->currency == 'USD')
                                                <li class="list-group-item">
                                                    №: {{$user_account->account}} Сумма: {{$user_account->amount}}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="col-md-3">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-primary">
                                            Счет в валюте EUR
                                        </li>
                                        @foreach($user_accounts as $user_account)
                                            @if($user_account->currency == 'EUR')
                                                <li class="list-group-item">
                                                    №: {{$user_account->account}} Сумма: {{$user_account->amount}}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->id == $user->id)
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="card">
                    <div class="card-header"><h3>Создать пользовательский счет</h3></div>

                    <div class="card-body">

                        <form action="{{ route('account.create') }}" method="post">
                            {{csrf_field()}}
                            <input class="form-check-input" type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="currency" class="form-control form-control-sm">
                                        <option value="0" selected disabled>Выберите счет</option>
                                        @foreach($currencies as $i => $currency)
                                            <option value="{{ $currency['currency'] }}">
                                                {{ $currency['amount'] }} {{ $currency['currency'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success mt-2">Создать счет</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Перевести деньги на другой счет</h3></div>

                        <div class="card-body">

                            <form action="{{ route('money.transfer') }}" method="post">
                                {{csrf_field()}}
                                <input class="form-check-input" type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <div class="form-group col-md-5">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Ваш счет</label>
                                        </div>
                                        <select class="custom-select" id="money-transfer-payer-account" name="payerAccount">
                                            @foreach($user_accounts as $user_account)
                                                <option value="{{ $user_account['account'] }}">
                                                    {{ $user_account['amount'] }} {{ $user_account['currency'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Сумма</span>
                                        </div>
                                        <input type="text" class="form-control" name="payerSum">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Счет получателя</span>
                                        </div>
                                        <input type="text" class="form-control" name="receiverAccount">
                                    </div>
                                    <button class="btn btn-success mt-2">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
