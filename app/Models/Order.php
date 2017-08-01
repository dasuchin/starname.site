<?php

namespace App\Models;

use App\Traits\ResolvesOrderProperties;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use ResolvesOrderProperties;

    protected $guarded = [];

    /**               */
    /** Relationships */
    /**               */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function star()
    {
        return $this->belongsTo('App\Models\Star');
    }

    /**           */
    /** Accessors */
    /**           */

    /**
     * @return string
     */
    public function getDedicationAttribute()
    {
        $prefix = $this->getDedicationPrefix();
        $name = ucwords($this->getDedicationName());

        return (!empty($prefix)) ? $prefix . $name : $name;
    }

    /**                */
    /** Public methods */
    /**                */

    /**
     * @return bool
     */
    public function orderInProgress()
    {
        return !empty(\Session::get('order')) ? true : false;
    }

    /**
     * @return bool
     */
    public function isSubscription()
    {
        return ($this->getPackage() == "digital_membership" || $this->getPackage() == "premium_membership" || $this->getPackage() == "ultimate_membership");
    }

    /**         */
    /** Getters */
    /**         */

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return \Session::get('order.package', false) ?: object_get($this, 'package', '');
    }

    /**
     * @return mixed
     */
    public function getPackageTranslated()
    {
        return $this->resolvePackageDescriptionFromCode($this->getPackage());
    }

    /**
     * @return mixed
     */
    public function getZodiacSign()
    {
        return \Session::get('order.zodiac', false) ?: object_get($this, 'zodiac', '');
    }

    /**
     * @return string
     */
    public function getDedication()
    {
        $prefix = $this->getDedicationPrefix();
        $name = ucwords($this->getDedicationName());

        return (!empty($prefix)) ? $prefix . $name : $name;
    }

    /**
     * @return mixed
     */
    public function getDedicationPrefix()
    {
        $prefix = \Session::get('order.prefix', false) ?: object_get($this, 'prefix', '');

        return $this->resolvePrefixFromIndex($prefix);
    }

    /**
     * @return mixed
     */
    public function getDedicationName()
    {
        return \Session::get('order.name', false) ?: object_get($this, 'name', '');
    }

    /**
     * @return mixed
     */
    public function getDedicationDate()
    {
        return \Session::get('order.dedication_date', false) ?: object_get($this, 'dedication_date', '');
    }

    /**
     * @return mixed
     */
    public function getMagnitude()
    {
        return \Session::get('order.magnitude', false) ?: object_get($this, 'magnitude', '');
    }

    /**
     * @return mixed
     */
    public function getVip()
    {
        return \Session::get('order.use_vip', false) ?: object_get($this, 'use_vip', 0);
    }

    public function getPaymentMethod()
    {
        return \Session::get('order.payment_method', '');
    }

    /**
     * @return mixed
     */
    public function getBillingState()
    {
        return \Session::get('order.billing_state', '');
    }

    /** Setters */

    /**
     * @param $package
     */
    public function setPackage($package)
    {
        \Session::put('order.package', $package);
    }

    /**
     * @param $zodiac
     */
    public function setZodiacSign($zodiac)
    {
        \Session::put('order.zodiac', $zodiac);
    }

    /**
     * @param $prefix
     */
    public function setDedicationPrefix($prefix)
    {
        \Session::put('order.prefix', $prefix);
    }

    /**
     * @param $name
     */
    public function setDedicationName($name)
    {
        \Session::put('order.name', $name);
    }

    /**
     * @param $dedication_date
     */
    public function setDedicationDate($dedication_date)
    {
        \Session::put('order.dedication_date', $dedication_date);
    }

    /**
     * @param $magnitude
     */
    public function setMagnitude($magnitude)
    {
        \Session::put('order.magnitude', $magnitude);
    }

    /**
     * @param $vip
     */
    public function setVip($vip)
    {
        \Session::put('order.use_vip', $vip);
    }

    /**
     * @param $method
     */
    public function setPaymentMethod($method)
    {
        \Session::put('order.payment_method', $method);
    }

    /**
     * @param $state
     */
    public function setBillingState($state)
    {
        \Session::put('order.billing_state', $state);
    }
}
