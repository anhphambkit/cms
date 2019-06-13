<?php

namespace Plugins\Customer\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Plugins\Product\Models\WishList;

/**
 * Plugins\Customer\Models\Customer
 *
 * @mixin \Eloquent
 */
class Customer extends Authenticatable
{
	use Notifiable;
	
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'username',
        'last_name',
        'email',
        'password',
        'avatar',
        'dob',
        'phone',
        'confirmed_at',
        'description',
        'gender',
        'status',
        'address',
        'secondary_address',
        'job_position',
        'secondary_phone',
        'secondary_email',
        'website',
        'skype',
        'facebook',
        'twitter',
        'google_plus',
        'youtube',
        'github',
        'interest',
        'about',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param int $customerId
     * @return mixed
     */
    public function wishListProducts(int $customerId)
    {
        return $this->hasMany(WishList::class)->where('customer_id', $customerId);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MemberResetPassword($token));
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        if (!$this->attributes['avatar']) {
            return (new Gravatar())->image($this->attributes['email']);
        }
        return url($this->attributes['avatar']);
    }

    /**
     * Always capitalize the first name when we retrieve it
     * @param string $value
     * @return string
     * @author Trinh Le
     */
    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Always capitalize the last name when we retrieve it
     * @param string $value
     * @return string
     * @author Trinh Le
     */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return string
     * @author Trinh Le
     */
    public function getFullName()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * @return string
     * @author Trinh Le
     */
    public function getProfileImage()
    {
        return $this->getAvatarAttribute();
    }
}
