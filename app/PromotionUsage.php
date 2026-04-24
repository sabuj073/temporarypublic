<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionUsage extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function promotion()
    {
        return $this->belongsTo(\App\Promotion::class, 'promotion_id');
    }

    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class, 'transaction_id');
    }
}
