<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartClusteredStations extends Model
{
    protected $table = "petrosmart_clustered_stations";

    protected $appends = ['date_created', 'stations_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getStationsChosenAttribute()
    {
        $string_version = "";

        if (!empty($this->fuel_stations_list)) {
            // first convert the string to array 
            $stringStationsIds = explode(',', $this->fuel_stations_list);
            $allStationsData = array();

            foreach ($stringStationsIds as $Stations) {
                $data = PetrosmartFuelStation::where("station_id", $Stations)->first();
                array_push($allStationsData, $data->name);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allStationsData);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }
        return $string_version;
    }
}
