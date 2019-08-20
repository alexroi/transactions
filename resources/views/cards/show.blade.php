@php

/** @var $card \App\Models\UserCard */
/** @var $transactions \App\Models\UserCardTransaction[] */

@endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('site.cards') }}">&larr; Back to list</a>
                        <br/>
                        Card - {{ $card->formatted_number }}
                        <br/>
                        Balance - {{ $card->cash }}
                    </div>
                    <div class="card-header">
                        <a href="{{ route('site.cards.replenish', ['card' => $card]) }}">Replenish Cash</a>,
                        <a href="{{ route('site.cards.withdraw', ['card' => $card]) }}">Withdraw Cash</a>,
                        <a href="{{ route('site.cards.transfer', ['card' => $card]) }}">Transfer Cash</a>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(count($transactions))
                            <div class="form-group row">
                                <span class="col-md-3">Card Number</span>
                                <span class="col-md-3">Source</span>
                                <span class="col-md-3">Last Change</span>
                                <span class="col-md-3">Amount</span>
                            </div>
                            @foreach($transactions as $transaction)
                                <div class="form-group row">
                                    <span class="col-md-3">{{ $transaction->card->formatted_number }}</span>
                                    <span class="col-md-3">{{ $transaction->sourceCard ? $transaction->sourceCard->hidden_number : '-' }}</span>
                                    <span class="col-md-3">{{ $transaction->formatted_date }}</span>
                                    <span class="col-md-3">{{ $transaction->amount }}</span>
                                </div>
                            @endforeach

                            <div>
                                {{ $transactions->links() }}
                            </div>
                        @else
                            <p>No transactions have been made yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
