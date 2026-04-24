<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTier extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function contacts()
    {
        return $this->hasMany(\App\Contact::class, 'loyalty_tier_id');
    }
}
