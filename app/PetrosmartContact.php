<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartContact extends Model
{
    protected $table = "petrosmart_customer_contact";

    protected $appends = ['date_created', 'customer_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

    public function getCustomerChosenAttribute()
    {
        $data = PetrosmartCustomers::where("cust_id", $this->full_name)->first();
        return $data->full_name;
   
    }
}
