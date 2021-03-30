<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class PetrosmartFuelVouchers extends Model
{
    protected $table = "petrosmart_fuel_voucher";

    protected $appends = ['date_created', 'customer_chosen', 'type_chosen', 'branch_chosen', 'driver_chosen', 'voucher_expiry_date'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getVoucherExpiryDateAttribute()
    {
        return Carbon::parse($this->expiry_date)->toFormattedDateString();
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->customer)->first();
        return $data->full_name;
    }

    public function getBranchChosenAttribute()
    {
        $data = PetrosmartBranch::where("custb_id", $this->branch_id)->first();
        return $data->name;
    }

    public function getDriverChosenAttribute()
    {
        $string_version = "";

        if (!empty($this->drivers)) {
        // if (strpos($this->drivers, ' ') !== false) {
            // first convert the string to array 
            $stringVehicleIds = explode(',', $this->drivers);
            $allVehicleData = array();

            foreach ($stringVehicleIds as $vehicle) {
                $data = PetrosmartDrivers::where("driver_id", $vehicle)->first();
                array_push($allVehicleData, $data->name);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allVehicleData);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }
        return $string_version;
    }

    public function getTypeChosenAttribute()
    {
        if (strtolower($this->voucher_type) == "single_use") {
            return "Single Use";
        }

        if (strtolower($this->voucher_type) == "multiple_use") {
            return "Multiple Use";
        }
    }
}
