<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartFuelAttendants;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class StationAttendantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.fuel_stations.attendants.dashboard');
    }

    // add fuel attendants
    public function addPetrosmartFuelAttendantsApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelAttendants::where("att_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelAttendants::where("att_id", $request->get('user_id'))->first();
            $message = "Successfully edited attendant";
        } else {
            $creatorForm = new PetrosmartFuelAttendants();
            $message = "Attendant was created successfully";
        }

        $creatorForm->att_id =  $request->get('user_id');
        $creatorForm->name =  $request->get('name');
        $creatorForm->address =  $request->get('address');
        $creatorForm->dob =  $request->get('dob');
        $creatorForm->email =  $request->get('email');
        $creatorForm->tel =  $request->get('tel');
        $creatorForm->mob =  $request->get('mob');
        $creatorForm->pin =  $request->get('pin');
        $creatorForm->station_id =  $request->get('fuelStation');
        $creatorForm->linked_pos =  $request->get('selectedPos');
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

    // get all data in fuel attendants 
    public function getFuelAttendantsDataApi(Request $request)
    {
        $model = PetrosmartFuelAttendants::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('att_id', "<>", "")
                        ->whereNotNull('att_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('att_id', "<>", "")
                        ->whereNotNull('att_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('att_id', "<>", "")
                        ->whereNotNull('att_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
