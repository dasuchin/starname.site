<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are dates
     *
     * @var array
     */
    protected $dates = [
        'cancel_date'
    ];

    /** Relationships */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->hasOne('App\User')->withTimestamps();
    }

    /** Public methods */

    /**
     * @return mixed
     */
    public function getCreditCardMaskedAttribute()
    {
        $formats = [
            "Visa"              => "4XXX XXXX XXXX ____",
            "American Express"  => "3XXX XXXXXXX X____",
            "MasterCard"        => "5XXX XXXX XXXX ____",
            "Discover"          => "6011 XXXX XXXX ____",
            "JCB"               => "35XX XXXX XXXX ____",
            "Diners Club"       => "3XXX XXXXXX ____",
            "Unknown"           => "-____"
        ];
        return str_replace("____", $this->cc_last4, $formats[$this->cc_type]);
    }

    /**
     * @return mixed
     */
    public function getStripeCustomerId()
    {
        return $this->stripe_customer_id;
    }
}