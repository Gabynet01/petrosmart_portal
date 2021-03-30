<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartBranch;
use App\PetrosmartVehicles;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CompanyVehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.vehicles.dashboard');
    }

    // add Vehicle Api
    public function addPetrosmartVehicleApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartVehicles::where("veh_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartVehicles::where("veh_id", $request->get('user_id'))->first();
            $message = "Successfully edited vehicle";
        } else {
            $creatorForm = new PetrosmartVehicles();
            $message = "Vehicle was created successfully";

            //check if rules has been set for selected branch
            if (PetrosmartBranch::where("custb_id", $request->get('addVehicleBranchSelect'))->exists()) {
                $checkBranchRules = PetrosmartBranch::where("custb_id", $request->get('addVehicleBranchSelect'))->first();

                if ($checkBranchRules->set_rules == NULL) {
                    $creatorForm->set_rules = NULL;
                } else {
                    $creatorForm->set_rules =  $checkBranchRules->set_rules;
                }
            }
        }

        $creatorForm->veh_id =  $request->get('user_id');
        $creatorForm->name =  $request->get('addVehicleName');
        $creatorForm->make =  $request->get('addVehicleMake');
        $creatorForm->model =  $request->get('addVehicleModel');
        $creatorForm->veh_type =  $request->get('addVehicleType');
        $creatorForm->number_plate =  $request->get('addVehiclePlate');
        $creatorForm->fuel_type =  $request->get('addVehicleFuelType');
        $creatorForm->reg_date =  $request->get('addVehicleRegistrationDate');
        $creatorForm->drivers_selected =  $request->get('addVehicleDriverSelect');
        $creatorForm->branch_id =  $request->get('addVehicleBranchSelect');
        $creatorForm->customer_id =  $request->get('addVehicleCompanySelect');
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

    // get all data in drivers 
    public function getVehicleDataApi(Request $request)
    {
        $model = PetrosmartVehicles::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('veh_id', "<>", "")
                        ->whereNotNull('veh_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('veh_id', "<>", "")
                        ->whereNotNull('veh_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('veh_id', "<>", "")
                        ->whereNotNull('veh_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }
}
