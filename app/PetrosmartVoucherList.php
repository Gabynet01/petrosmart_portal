<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartVoucherList extends Model
{
    protected $table = "petrosmart_voucher_list";

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
        $data = PetrosmartFuelVouchers::where("fv_id", $this->parent_voucher_id)->first();
        if (empty($data)) {
            return "";
        } else {
            $custData = PetrosmartCustomers::where("cust_id", $data->customer)->first();
            return $custData->full_name;
        }
    }

    public function getBranchChosenAttribute()
    {
        $data = PetrosmartFuelVouchers::where("fv_id", $this->parent_voucher_id)->first();
        if (empty($data)) {
            return "";
        } else {

            $finalData = PetrosmartBranch::where("customer_selected", $data->customer)->first();
            return $finalData->name;
        }
    }

    public function getDriverChosenAttribute()
    {
        $data = PetrosmartDrivers::where("driver_id", $this->driver_id)->first();
        if (empty($data)) {
            return "";
        } else {
            return $data->name;
        }
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
