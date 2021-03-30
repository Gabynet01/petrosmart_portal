<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class PetrosmartFuelStation extends Model
{
    protected $table = "petrosmart_fuel_station";

    protected $appends = ['date_created', 'country_chosen', 'omc_chosen', 'pos_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCountryChosenAttribute()
    {
        $data = PetrosmartCountries::where("ccountry_id", $this->omccountry_id)->first();
        return $data->country;
    }

    public function getOmcChosenAttribute()
    {
        $data = PetrosmartOMC::where("omc_id", $this->linked_omc)->first();
        return $data->name;
    }

    public function getPosChosenAttribute()
    {

        $string_version = "";

        if (!empty($this->pos_selected)) {
        // if (strpos($this->pos_selected, ' ') !== false) {
            // first convert the string to array 
            $stringPosIds = explode(',', $this->pos_selected);
            $allPos = array();

            foreach ($stringPosIds as $pos) {
                $data = PetrosmartFuelPOS::where("pos_id", $pos)->first();
                array_push($allPos, $data->make);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allPos);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }
        return $string_version;
    }
}
