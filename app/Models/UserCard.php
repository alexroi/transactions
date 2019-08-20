<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * App\Models\UserCard
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $number
 * @property string $pin
 * @property float $cash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard wherePin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCard whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserCardTransaction[] $transactions
 * @property-read string $formatted_number
 * @property-read string $hidden_number
 * @property-read string $last_change
 */
class UserCard extends Model
{
    protected $table = 'users_cards';

    protected $fillable = ['user_id', 'number', 'cash'];

    protected $casts = ['cash' => 'float'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(UserCardTransaction::class, 'card_id', 'id');
    }


    public function changeBalance(float $amount, ?UserCard $source_card = null)
    {
        $card = $this;
        \DB::transaction(function () use ($card, $amount, $source_card) {
            /** @var UserCard $card */
            $card->cash += $amount;
            $card->save();
            $card->transactions()->create([
                'amount' => $amount,
                'source_card_id' => $source_card ? $source_card->id : null
            ]);

            if($source_card){
                $source_card->cash += -$amount;

                $source_card->transactions()->create([
                    'amount' => -$amount,
                    'source_card_id' => $card->id
                ]);
            }
        });
    }


    /**
     * @return string
     */
    public function getFormattedNumberAttribute(): string
    {
        if (!$this->number) {
            return '';
        }

        return substr($this->number, 0, 4)
            . '-' .
            substr($this->number, 4, 4)
            . '-' .
            substr($this->number, 8, 4)
            . '-' .
            substr($this->number, 12, 4);
    }


    /**
     * @return string
     */
    public function getHiddenNumberAttribute(): string
    {
        if (!$this->number) {
            return '';
        }

        return '****-****-****-' . substr($this->number, 12, 4);
    }


    /**
     * @return string
     */
    public function getLastChangeAttribute(): string
    {
        if (!$this->updated_at) {
            return '';
        }

        return Carbon::parse($this->updated_at)->format('d.m.Y H:i');
    }


    /**
     * @return string
     */
    public static function generateCardNumber()
    {
        $new_number = mt_rand(1111, 9999) . mt_rand(1111, 9999) . mt_rand(1111, 9999) . mt_rand(1111, 9999);

        if (UserCard::whereNumber($new_number)->first()) {
            $new_number = self::generateCardNumber();
        }

        return $new_number;
    }


    /**
     * @param int $pin
     * @param int $user_id
     */
    public static function createCard(int $pin, int $user_id)
    {
        $card = new UserCard();
        $card->number = UserCard::generateCardNumber();
        $card->pin = Hash::make($pin);
        $card->user_id = $user_id;
        $card->save();
    }
}
