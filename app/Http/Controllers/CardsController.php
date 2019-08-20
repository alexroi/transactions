<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardCreateRequest;
use App\Http\Requests\CardReplenishRequest;
use App\Http\Requests\CardTransferRequest;
use App\Http\Requests\CardWithdrawRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use App\Models\UserCard;
use App\Models\UserCardTransaction;

class CardsController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = \Auth::user();
        $cards = UserCard::whereUserId($user->id)->latest('updated_at')->get();

        return view('cards.index', [
            'cards' => $cards
        ]);
    }


    /**
     * Create card page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('cards.create');
    }


    /**
     * Store new card
     *
     * @param CardCreateRequest $request
     * @return mixed
     */
    public function store(CardCreateRequest $request)
    {
        UserCard::createCard($request->input('pin'), \Auth::user()->id);

        return redirect(route('site.cards'));
    }


    /**
     * Show card info
     *
     * @param UserCard $card
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(UserCard $card)
    {
        $transactions = UserCardTransaction::whereCardId($card->id)->latest()->paginate(10);

        return view('cards.show', [
            'card' => $card,
            'transactions' => $transactions
        ]);
    }


    public function replenish(UserCard $card)
    {
        return view('cards.replenish', [
            'card' => $card
        ]);
    }


    public function replenishStore(CardReplenishRequest $request, UserCard $card)
    {
        $card->changeBalance($request->input('amount'));

        return redirect(route('site.cards.show', ['card' => $card]));
    }


    public function withdraw(UserCard $card)
    {
        return view('cards.withdraw', [
            'card' => $card
        ]);
    }


    public function withdrawStore(CardWithdrawRequest $request, UserCard $card)
    {
        $amount = -1 * abs($request->input('amount'));

        $card->changeBalance($amount);

        return redirect(route('site.cards.show', ['card' => $card]));
    }


    public function transfer(UserCard $card)
    {
        return view('cards.transfer', [
            'card' => $card
        ]);
    }


    public function transferStore(CardTransferRequest $request, UserCard $card)
    {
        $transfer_card = UserCard::whereNumber($request->input('number'))->first();

        $transfer_card->changeBalance($request->input('amount'), $card);

        return redirect(route('site.cards.show', ['card' => $card]));
    }
}
