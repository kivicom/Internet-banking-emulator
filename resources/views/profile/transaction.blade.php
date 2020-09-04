@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>Архив транзакций</h3></div>

                    <div class="card-body">
                        @if (session('profile'))
                            <div class="alert alert-success" role="alert">
                                {{ session('profile') }}
                            </div>
                        @endif

                        <div class="row">

                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Дата</th>
                                            <th scope="col">Со счета</th>
                                            <th scope="col">На счет</th>
                                            <th scope="col">Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $i => $transaction)
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td>{{ $transaction->created_at }}</td>
                                            <td>{{ $transaction->currency_from }} {{ $transaction->account_from }}</td>
                                            <td>{{ $transaction->currency_to }} {{ $transaction->account_to }}</td>
                                            <td>{{ $transaction->amount }} {{ $transaction->currency_from }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
