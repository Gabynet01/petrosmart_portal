<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class PetrosmartFuelStationWallet extends Model
{
    protected $table = "petrosmart_fuelstation_wallet";

    protected $appends = ['date_created', 'station_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getStationChosenAttribute()
    {
        $data = PetrosmartFuelStation::where("station_id", $this->fuel_station_id)->first();
        return $data->name;
   
    }
}
