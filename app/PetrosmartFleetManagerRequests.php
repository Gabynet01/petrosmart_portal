<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartFleetManagerRequests extends Model
{
    protected $table = "petrosmart_fleet_manager_requests";

    protected $appends = ['date_created', 'customer_chosen', 'driver_chosen', 'station_wallet_chosen', 'station_id_chosen', 'company_wallet_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->company_id)->first();
        return $data->full_name;
    }

    public function getDriverChosenAttribute()
    {
        $data = PetrosmartDrivers::where("driver_id", $this->driver_id)->first();
        return $data->name;
   
    }

    public function getStationWalletChosenAttribute()
    {
        $data = PetrosmartFuelStationWallet::where("custw_id", $this->station_wallet_id)->first();
        return $data->wallet_num;
   
    }

    public function getStationIdChosenAttribute()
    {
        $data = PetrosmartFuelStationWallet::where("custw_id", $this->station_wallet_id)->first();
        return $data->fuel_station_id;
   
    }

    public function getCompanyWalletChosenAttribute()
    {
        $data = PetrosmartWallet::where("custw_id", $this->company_wallet_id)->first();
        return $data->wallet_num;
   
    }
}
