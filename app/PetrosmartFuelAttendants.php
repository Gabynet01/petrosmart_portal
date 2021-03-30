<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartFuelAttendants extends Model
{
    protected $table = "petrosmart_fuel_attendant";

    protected $appends = ['date_created', 'station_chosen', 'pos_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getStationChosenAttribute()
    {
        $data = PetrosmartFuelStation::where("station_id", $this->station_id)->first();
        return $data->name;
   
    }

    public function getPosChosenAttribute()
    {
        $data = PetrosmartFuelPOS::where("pos_id", $this->linked_pos)->first();
        return $data->make ." - ". $data->model;
   
    }
}
