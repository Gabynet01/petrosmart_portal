<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartCustomers extends Model
{
    protected $table = "petrosmart_customer";

    protected $appends = ['date_created', 'country_chosen', 'industry_chosen', 'manager_chosen'];

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

    public function getManagerChosenAttribute()
    {
        $string_version = "";

        if (!empty($this->assigned_managers)) {
            $stringManagerIds = explode(',', $this->assigned_managers);
            $allManagerData = array();

            foreach ($stringManagerIds as $manager) {
                $data = PetrosmartFleetManagers::where("user_id", $manager)->first();
                array_push($allManagerData, $data->name);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allManagerData);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }
        return $string_version;
    }

}
