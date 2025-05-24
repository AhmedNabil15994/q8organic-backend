<?php

namespace Modules\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\Catalog\Entities\Product;
use Modules\Core\Traits\ScopesTrait;
use Modules\Notification\Entities\GeneralNotification;
use Modules\Occasion\Entities\Occasion;
use Modules\Order\Entities\Order;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements \Tocaan\FcmFirebase\Contracts\IFcmFirebaseDevice
{
    // protected $with   = ['roles'];
    use \Tocaan\FcmFirebase\Traits\FcmDeviceTrait;

    use Notifiable, ScopesTrait, HasApiTokens;
    use EntrustUserTrait {
        EntrustUserTrait::restore as private restoreA;
    }
    use SoftDeletes {
        EntrustUserTrait::restore as private restoreB;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        "setting" => "array",
        "is_verified" => "boolean",
    ];

    public function getImageAttribute($value)
    {
        return is_null($value) ? '/uploads/users/user.png' : $value;
    }

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function driverOrders()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderDriver::class);
    }

    public function country()
    {
        return $this->belongsTo(\Modules\Area\Entities\Country::class);
    }

    public function successOrders()
    {
        return $this->hasMany(Order::class)->whereHas('paymentStatus' , function ($q){

            $q->whereIn('flag' , ['success']);
        });
    }

    public function city()
    {
        return $this->belongsTo(\Modules\Area\Entities\City::class);
    }

    public function company()
    {
        return $this->belongsTo(\Modules\Company\Entities\Company::class, 'company_id');
    }

    public function occasions()
    {
        return $this->hasMany(Occasion::class, 'user_id');
    }

    public function favourites()
    {
        return $this->belongsToMany(Product::class, 'users_favourites');
    }

    public function generalNotifications()
    {
        return $this->hasMany(GeneralNotification::class, 'user_id');
    }

    public function mobileCodes()
    {
        return $this->hasMany(UserMobileCode::class, 'user_id');
    }

    public function preferredLocale()
    {
        return $this->setting["lang"] ?? locale();
    }

    public function getPhone()
    {
        return $this->calling_code . $this->mobile;
    }

    /* public function setCountryCodeAttribute($value)
     {
         $this->attributes['country_code'] = $value;
         $this->attributes['dial_code'] = app('countries')->formattedDialCode($value);
     }*/
}
