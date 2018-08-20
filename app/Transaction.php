<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $dates = ['request_date', 'bank_process_date'];

    protected $guarded = [];

    protected $primaryKey = 'transaction_id';


    /**
     * Obtiene el campo con el que se va a hacer model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'reference';
    }

    /*
    |---------------------------------------------------------------------------------------
    |  RELATIONSHIPS
    |---------------------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |---------------------------------------------------------------------------------------
    | MUTATORS 
    |---------------------------------------------------------------------------------------
    */

    public function setRequestDateAttribute($value)
    {
        $this->attributes['request_date'] = Carbon::parse($value);
    }

    public function setBankProcessDateAttribute($value)
    {
        $this->attributes['bank_process_date'] = Carbon::parse($value);
    }

    
    /**
     * Mutator para almacenar el campo amount en formato
     * compatible con decimal en DB. Esto es debido a que el precio
     * esta con format_number, y esta funcion, remueve la comas de ese formato.
     * 
     **/
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = str_replace(',', '',$value);
    }


    /*
    |---------------------------------------------------------------------------------------
    | ACCESSORS 
    |---------------------------------------------------------------------------------------
    */

    public function getAmountAttribute($value)
    {
        return number_format($value);
    }
}
