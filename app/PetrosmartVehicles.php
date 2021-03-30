<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartVehicles extends Model
{
    protected $table = "petrosmart_vehicles";

    protected $appends = ['date_created', 'branch_chosen', 'customer_chosen', 'driver_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getBranchChosenAttribute()
    {
        $data = PetrosmartBranch::where("custb_id", $this->branch_id)->first();
        return $data->name;
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->customer_id)->first();
        return $data->full_name;
    }

    public function getDriverChosenAttribute()
    {
        $string_version = "";

        if (!empty($this->drivers_selected)) {
        // if (strpos($this->drivers_selected, ' ') !== false) {
            // first convert the string to array 
            $stringVehicleIds = explode(',', $this->drivers_selected);
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

    // public function getDriverChosenAttribute()
    // {
    //     $data = PetrosmartDrivers::where("driver_id", $this->driver_id)->first();
    //     return $data->name;

    // }
}
