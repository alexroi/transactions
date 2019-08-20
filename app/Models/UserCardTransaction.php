<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCardTransaction
 *
 * @property int $id
 * @property int|null $card_id
 * @property float $amount
 * @property int|null $source_card_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereSourceCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCardTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserCard|null $card
 * @property-read \App\Models\UserCard|null $sourceCard
 * @property-read string $formatted_date
 */
class UserCardTransaction extends Model
{

    protected $table = 'users_cards_transactions';

    protected $fillable = ['card_id', 'amount', 'source_card_id'];

    protected $casts = ['cash' => 'float'];

    public function card()
    {
        return $this->belongsTo(UserCard::class, 'card_id', 'id');
    }

    public function sourceCard()
    {
        return $this->belongsTo(UserCard::class, 'source_card_id', 'id');
    }


    /**
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        if (!$this->created_at) {
            return '';
        }

        return Carbon::parse($this->created_at)->format('d.m.Y H:i');
    }
}
