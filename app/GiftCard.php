<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Contact::class, 'contact_id');
    }

    public function linkedSale()
    {
        return $this->belongsTo(\App\Transaction::class, 'linked_sale_id');
    }

    public function created_user()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function gift_card_transactions()
    {
        return $this->hasMany(\App\GiftCardTransaction::class, 'gift_card_id');
    }
}
