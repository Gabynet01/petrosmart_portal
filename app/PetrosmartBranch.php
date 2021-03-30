<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartBranch extends Model
{
    protected $table = "petrosmart_customer_branch";

    protected $appends = ['date_created', 'customer_chosen', 'country_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->customer_selected)->first();
        return $data->full_name;
   
    }

    public function getCountryChosenAttribute()
    {
        $data = PetrosmartCountries::where("ccountry_id", $this->ccountry_id)->first();
        return $data->country;
   
    }
}
