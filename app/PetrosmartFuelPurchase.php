<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartFuelPurchase extends Model
{
    protected $table = "petrosmart_fuel_purchase";

    protected $appends = ['date_created', 'station_chosen', 'customer_chosen', 'date_chosen', 'driver_chosen', 'vehicle_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getStationChosenAttribute()
    {
        $data = PetrosmartFuelStation::where("station_id", $this->station_id)->first();
        return $data->name;
   
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->customer)->first();
        return $data->full_name;
   
    }

    public function getDriverChosenAttribute()
    {
        $data = PetrosmartDrivers::where("driver_id", $this->driver_selected)->first();
        return $data->name;
   
    }

    public function getVehicleChosenAttribute()
    {
        $data = PetrosmartVehicles::where("veh_id", $this->driver_vehicle_selected)->first();
        return $data->name;
   
    }

    public function getDateChosenAttribute()
    {
        return Carbon::parse($this->purchase_date)->toDayDateTimeString();
    }
}
