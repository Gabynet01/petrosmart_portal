<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartDrivers;
use App\PetrosmartBranch;
use App\PetrosmartVehicles;
use App\UserDriversModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CompanyDriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.drivers.dashboard');
    }

    // add Driver Api
    public function addPetrosmartDriverApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');
        $session_id = Session::get('userId');

        $setRules = "";

        if (PetrosmartDrivers::where("driver_id", $request->get('driver_id'))->exists()) {
            $creatorForm = PetrosmartDrivers::where("driver_id", $request->get('driver_id'))->first();
            $requesterForm =  UserDriversModel::where("id", $request->get('driver_id'))->first();
            $message = "Successfully edited driver";
        } else {

            $creatorForm = new PetrosmartDrivers();
            $requesterForm = new UserDriversModel();

            $statement = DB::select("show table status like 'user_drivers'");

            $creatorForm->driver_id =  $statement[0]->Auto_increment;
            $message = "Driver was created successfully";

            //check if rules has been set for selected branch
            if (PetrosmartBranch::where("custb_id", $request->get('addBranchSelect'))->exists()) {
                $checkBranchRules = PetrosmartBranch::where("custb_id", $request->get('addBranchSelect'))->first();

                if ($checkBranchRules->set_rules == NULL) {
                    $creatorForm->set_rules = NULL;
                } else {
                    $creatorForm->set_rules =  $checkBranchRules->set_rules;
                }
            }
        }

        $creatorForm->customer_id =  $request->get('addDriverCompanySelect');
        $creatorForm->branch_id =  $request->get('addBranchSelect');
        $creatorForm->address =  $request->get('addDriverAddress');
        $creatorForm->dob =  $request->get('addDobDriver');
        $creatorForm->name =  $request->get('addDriverName');
        $creatorForm->email =  $request->get('addDriverEmail');
        $creatorForm->mob =  $request->get('addDriverPhone');
        $creatorForm->device_id =  $request->get('addDeviceSelect');
        $creatorForm->vehicles_selected =  $request->get('addDriverVehiclesSelect');
        $creatorForm->created_by =  $session_email;
        $creatorForm->updated_at =  Carbon::now();


        // lets send the update to the user drivers table

        $requesterForm->user_id =  $session_id;
        $requesterForm->name =  $request->get('addDriverName');
        $requesterForm->phone =  $request->get('addDriverPhone');
        $requesterForm->email =  $request->get('addDriverEmail');
        $requesterForm->device_id =  $request->get('addDeviceSelect');
        $requesterForm->updated_at =  Carbon::now();


        $saveResults = 0;
        $saveResults2 = 0;
        DB::beginTransaction();
        $saveResults = $creatorForm->save();
        $saveResults2 = $requesterForm->save();
        DB::commit();

        if ($saveResults && $saveResults2) {
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
    public function getDriverDataApi(Request $request)
    {
        $model = PetrosmartDrivers::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('driver_id', "<>", "")
                        ->whereNotNull('driver_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('driver_id', "<>", "")
                        ->whereNotNull('driver_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('driver_id', "<>", "")
                        ->whereNotNull('driver_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // set driver rules here Api
    public function setRulesForDriversApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');
        $session_id = Session::get('userId');

        //lets check what module to call
        if ($request->get('selectedModule') == "DRIVER") {
            if (PetrosmartDrivers::where("driver_id", $request->get('selectedId'))->exists()) {
                $creatorForm = PetrosmartDrivers::where("driver_id", $request->get('selectedId'))->first();

                $message = "Successfully set rules for the driver";
            }
        }

        if ($request->get('selectedModule') == "VEHICLE") {
            if (PetrosmartVehicles::where("veh_id", $request->get('selectedId'))->exists()) {
                $creatorForm = PetrosmartVehicles::where("veh_id", $request->get('selectedId'))->first();

                $message = "Successfully set rules for the vehicle";
            }
        }

        if ($request->get('selectedModule') == "BRANCH") {
            if (PetrosmartBranch::where("custb_id", $request->get('selectedId'))->exists()) {
                $creatorForm = PetrosmartBranch::where("custb_id", $request->get('selectedId'))->first();

                $message = "Successfully set rules for the branch";
            }
        }

        $creatorForm->set_rules =  $request->get('rulesData');

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
}
