@php

/** @var $cards \App\Models\UserCard[] */

@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My cards</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($cards))
                        <div class="form-group row">
                            <span class="col-md-5">Card Number</span>
                            <span class="col-md-3">Last Change</span>
                            <span class="col-md-2">Cash</span>
                            <span class="col-md-2"></span>
                        </div>
                        @foreach($cards as $card)
                            <div class="form-group row">
                                <span class="col-md-5">
                                    <a href="{{ route('site.cards.show', ['card' => $card]) }}">{{ $card->formatted_number }}</a>
                                </span>
                                <span class="col-md-3">{{ $card->last_change }}</span>
                                <span class="col-md-2">{{ $card->cash }}</span>
                                <span class="col-md-2">
                                    @include('cards.operations-list', [
                                        'card' => $card,
                                    ])
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p>No cards available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
