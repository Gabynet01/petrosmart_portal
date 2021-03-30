<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartOMC extends Model
{
    protected $table = "petrosmart_omc";

    protected $appends = ['date_created', 'country_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCountryChosenAttribute()
    {
        $data = PetrosmartCountries::where("ccountry_id", $this->country)->first();
        return $data->country;
   
    }
}
