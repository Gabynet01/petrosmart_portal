<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class PetrosmartWallet extends Model
{
    protected $table = "petrosmart_customer_wallet";

    protected $appends = ['date_created', 'customer_chosen', 'branch_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->customer_selected)->first();
        return $data->full_name;
   
    }

    public function getBranchChosenAttribute()
    {
        $data = PetrosmartBranch::where("custb_id", $this->custb_id)->first();
        return $data->name;
   
    }
}
