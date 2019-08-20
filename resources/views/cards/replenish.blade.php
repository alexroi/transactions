@php

/** @var $card \App\Models\UserCard */

@endphp
@extends('layouts.app')
@section('title', 'Replenish cash')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('site.cards.show', ['card' => $card]) }}">&larr; Back</a>
                        <br/>
                        Card: {{ $card->formatted_number }}
                        <br/>
                        Balance: {{ $card->cash }}
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('site.cards.replenish.store', ['card' => $card]) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="pin" class="col-md-4 col-form-label text-md-right">Cash</label>

                                <div class="col-md-6">
                                    <input id="amount"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           name="amount"
                                           placeholder="10.00"
                                           value="{{ old('amount') }}"
                                           required>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pin" class="col-md-4 col-form-label text-md-right">Pin code</label>

                                <div class="col-md-6">
                                    <input id="pin" class="form-control @error('pin') is-invalid @enderror" maxlength="4" name="pin" value="{{ old('pin') }}" required>

                                    @error('pin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
