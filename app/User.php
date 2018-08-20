<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
        'document_type_id', 'email', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function routeNotificationForMail($notification)
    {
        return $this->email_address;
    }

    /*
    |---------------------------------------------------------------------------------------
    | RELATIONSHIPS 
    |---------------------------------------------------------------------------------------
    */

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }


    /*
    |---------------------------------------------------------------------------------------
    | MUTATORS 
    |---------------------------------------------------------------------------------------
    */

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords($value);
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = ucwords($value);
    }

    public function setProvinceAttribute($value)
    {
        $this->attributes['province'] = ucwords($value);
    }


    /*
    |---------------------------------------------------------------------------------------
    | ACCESSORS 
    |---------------------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
}
