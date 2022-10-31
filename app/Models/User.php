<?php

namespace App\Models;

use \DateTimeInterface;
use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Auditable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasFactory;
    use HasApiTokens;
    use Auditable;

    public const IS_ACTIVE_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const GENDER_RADIO = [
        '1' => 'Male',
        '2' => 'Female',
    ];

    public const IS_ENABLED_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public const LANGUAGE_SELECT = [
        'English' => 'English',
        'Dutch'   => 'Dutch',
        'French'  => 'French',
    ];

    public $table = 'users';

    public static $searchable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'remember_token', 'two_factor_code',
        'password',
    ];

    protected $dates = [
        'date_of_birth',
        'email_verified_at',
        'verified_at',
        'two_factor_expires_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'api_token',
        'sponsor_id',
        'date_of_birth',
        'gender',
        'language',
        'is_enabled',
        'is_active',
        'building_num',
        'street',
        'region',
        'postcode',
        'city',
        'country_id',
        'phone',
        'business_name',
        'vat_number',
        'bus_address_building_num',
        'bus_address_street',
        'bus_address_region',
        'bus_address_city',
        'bus_address_postcode',
        'bus_address_country_id',
        'business_phone',
        'is_delete',
        'image',
        'token',
        'notification_mail',
        'marketting_mail',
        'auth',
        'terms_conditions',
        'affiliate_disclosure',
        'privacy_disclosure',
        'reserve_wallet_commission_status',
        'email_verified_at',
        'approved',
        'verified',
        'verified_at',
        'verification_token',
        'two_factor',
        'remember_token',
        'two_factor_code',
        'two_factor_expires_at',
        'rank_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'product_id'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');
                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }

                //$user->notify(new VerifyUserNotification($user));
            }
        });
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps            = false;
        $this->two_factor_code       = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(15)->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps            = false;
        $this->two_factor_code       = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function sponsorUsers()
    {
        return $this->hasMany(User::class, 'sponsor_id', 'id');
    }

    public function userAllwallettransactions()
    {
        return $this->hasMany(Allwallettransaction::class, 'user_id', 'id');
    }

    public function userOrders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function resentVerificationMail($id)
    {
        $user = User::where('id','=', $id)->first();
        $user->notify(new VerifyUserNotification($user));
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

//    public function setDateOfBirthAttribute($value)
//    {
//        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
//    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function bus_address_country()
    {
        return $this->belongsTo(Country::class, 'bus_address_country_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getTwoFactorExpiresAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setTwoFactorExpiresAtAttribute($value)
    {
        $this->attributes['two_factor_expires_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function setImpersonating($id)
    {
        session(['id' => $id]);
    }

    public function stopImpersonating()
    {
            session()->forget('id');
        }

    public function isImpersonating()
    {
           return session()->has('id');
    }
}
