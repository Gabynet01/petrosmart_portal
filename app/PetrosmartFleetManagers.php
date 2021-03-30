<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartFleetManagers extends Model
{
    protected $table = "petrosmart_fleet_managers";

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
            //    if (strpos($this->drivers_selected, ' ') !== false) {
            // first convert the string to array 
            $stringDataIds = explode(',', $this->drivers_selected);
            $allData = array();
            // dd($stringDataIds);
            foreach ($stringDataIds as $selectedData) {
                $data = PetrosmartDrivers::where("driver_id", $selectedData)->first();
                array_push($allData, $data->name);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allData);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }

        return $string_version;
    }
}
