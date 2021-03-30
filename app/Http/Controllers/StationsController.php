<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartFuelStation;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class StationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.fuel_stations.stations.dashboard');
    }

    // add fuel stations
    public function addPetrosmartFuelStationApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelStation::where("station_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelStation::where("station_id", $request->get('user_id'))->first();
            $message = "Successfully edited fuel station";
        } else {
            $creatorForm = new PetrosmartFuelStation();
            $message = "Fuel station was created successfully";
        }

        $creatorForm->station_id =  $request->get('user_id');
        $creatorForm->name =  $request->get('name');
        $creatorForm->address =  $request->get('address');
        $creatorForm->gps =  $request->get('gps');
        $creatorForm->gps_radius =  $request->get('gpsRadius');
        $creatorForm->omccountry_id =  $request->get('country');
        $creatorForm->linked_omc =  $request->get('selectedOmc');
        $creatorForm->pos_selected =  $request->get('addStationPos');
        $creatorForm->created_by =  $session_email;


        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $creatorForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = $message;
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in fuel stations 
    public function getFuelStationsDataApi(Request $request)
    {
        $model = PetrosmartFuelStation::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('station_id', "<>", "")
                        ->whereNotNull('station_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('created_by', Session::get('email'))
                        ->where('station_id', "<>", "")
                        ->whereNotNull('station_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('created_by', Session::get('managerEmail'))
                        ->where('station_id', "<>", "")
                        ->whereNotNull('station_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
