<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCardsTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_cards_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('card_id')->unsigned()->nullable();
            $table->foreign('card_id')->references('id')->on('users_cards')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->index('users_cards_transactions_card_id_users_cards_id');

            $table->double('amount', 10,2)->default(0);
            $table->tinyInteger('type')->default(0)->unsigned()->comment('0 - replenishment| 1 - withdrawal');

            $table->bigInteger('source_card_id')->unsigned()->nullable();
            $table->foreign('source_card_id')->references('id')->on('users_cards')
                ->onDelete('set null')
                ->onUpdate('cascade')
                ->index('users_cards_transactions_source_card_id_users_cards_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_cards_transactions', function (Blueprint $table) {
            $table->dropForeign('users_cards_transactions_card_id_users_cards_id');
            $table->dropForeign('users_cards_transactions_source_card_id_users_cards_id');
        });
        Schema::dropIfExists('users_cards_transactions');
    }
}
