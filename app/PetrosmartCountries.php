<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartCountries extends Model
{
    protected $table = "petrosmart_customer_country";

    protected $appends = ['date_created'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }
}
