<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCardTransaction extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function gift_card()
    {
        return $this->belongsTo(\App\GiftCard::class, 'gift_card_id');
    }

    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class, 'transaction_id');
    }

    public function transaction_payment()
    {
        return $this->belongsTo(\App\TransactionPayment::class, 'transaction_payment_id');
    }

    public function created_user()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }
}
