<?php

namespace App;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements BillableContract
{
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that are dates
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at',
        'subscription_ends_at'
    ];

    /** Relationships */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /** Public methods */

    /**
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach($this->roles as $role) {
            if ($role->name == $name) return true;
        }
        return false;
    }

    /**
     * @param $role
     */
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * @param $role
     * @return int
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * @return bool
     */
    public function isSubscribed()
    {
        if (!empty($this->stripe_subscription)) {
            if ($this->subscription_ends_at > \Carbon\Carbon::today()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}