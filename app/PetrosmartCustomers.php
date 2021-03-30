<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartCustomers extends Model
{
    protected $table = "petrosmart_customer";

    protected $appends = ['date_created', 'country_chosen', 'industry_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCountryChosenAttribute()
    {
        $data = PetrosmartCountries::where("ccountry_id", $this->country)->first();
        return $data->country;
   
    }

    public function getIndustryChosenAttribute()
    {
        $data = PetrosmartIndustries::where("industry_id", $this->industry)->first();
        return $data->industry_name;
   
    }

}
