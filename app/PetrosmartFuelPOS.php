<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartFuelPOS extends Model
{
    protected $table = "petrosmart_pos";

    protected $appends = ['date_created'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }

}
