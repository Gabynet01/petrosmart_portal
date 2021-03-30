<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PetrosmartNotifications extends Model
{
    protected $table = "petrosmart_notifications";

    protected $appends = ['date_created', 'sub_heading_chosen'];

    public function getDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->toDayDateTimeString();
    }


    public function getSubHeadingChosenAttribute()
    {

        $string_version = "";

        // var_dump($this->sub_headings);

        if (!empty($this->sub_headings)) {
            // first convert the string to array 
            $stringDataIds = explode(',', $this->sub_headings);
            $allData = array();

            foreach ($stringDataIds as $data) {
                array_push($allData, $data);
            }

            // lets convert the array to string 
            $string_version = implode(',', $allData);

            // lets add a space after the comma
            $string_version = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $string_version);
        }
        return $string_version;
    }
}
