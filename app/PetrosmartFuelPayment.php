<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartFuelPayment extends Model
{
    protected $table = "petrosmart_fuel_payment";

    protected $appends = ['date_created', 'station_chosen', 'customer_chosen', 'voucher_chosen', 'date_chosen'];

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

    public function getVoucherChosenAttribute()
    {
        $data = PetrosmartFuelVouchers::where("fv_id", $this->voucher_id)->first();
        return $data->voucher_code;
   
    }

    public function getDateChosenAttribute()
    {
        return Carbon::parse($this->payment_date)->toDayDateTimeString();
    }
}
