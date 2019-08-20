@php

/** @var $card\App\Models\UserCard */

@endphp
<a id="cardMenu-{{ $card->id }}" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="cardMenu-{{ $card->id }}">
    <a class="dropdown-item" tabindex="-1" href="{{ route('site.cards.show', ['card' => $card]) }}">Card History</a>
    <a class="dropdown-item" tabindex="-1" href="{{ route('site.cards.replenish', ['card' => $card]) }}">Replenish Cash</a>
    <a class="dropdown-item" tabindex="-1" href="{{ route('site.cards.withdraw', ['card' => $card]) }}">Withdraw Cash</a>
    <a class="dropdown-item" tabindex="-1" href="{{ route('site.cards.transfer', ['card' => $card]) }}">Transfer Cash</a>
</div>
