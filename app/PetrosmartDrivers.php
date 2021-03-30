<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartDrivers extends Model
{
    protected $table = "petrosmart_drivers";

    protected $appends = ['date_created', 'branch_chosen', 'device_chosen', 'vehicle_chosen', 'customer_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getBranchChosenAttribute()
    {
        $data = PetrosmartBranch::where("custb_id", $this->branch_id)->first();
        return $data->name;
    }

    public function getDeviceChosenAttribute()
    {
        $data = DevicesModel::where("id", $this->device_id)->first();
        return $data->name;
    }

    public function getVehicleChosenAttribute()
    {
        $string_version = "";

        if (!empty($this->vehicles_selected)) {
        // if (strpos($this->vehicles_selected, ' ') !== false) {
            $stringVehicleIds = explode(',', $this->vehicles_selected);
            $allVehicleData = array();

            foreach ($stringVehicleIds as $vehicle) {
                $data = PetrosmartVehicles::where("veh_id", $vehicle)->first();
                array_push($allVehicleData, $data->name);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allVehicleData);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }
        return $string_version;
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->customer_id)->first();
        return $data->full_name;
    }
}
