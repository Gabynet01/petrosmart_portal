<?php

namespace App\Http\Controllers;

use App\AppUsersModel;
use App\PetrosmartFleetManagerRequests;
use App\PetrosmartFleetManagers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class FleetManagerController extends Controller
{
    // Load the manage application users dashboard
    public function manageApplicationUsers()
    {
        return view('petrosmart_pages.fleet_managers.fleetManagerUsers');
    }

    public function fleetManagerRequests()
    {
        return view('petrosmart_pages.fleet_managers.fleetManagerRequests');
    }

    public function makeApiCallToApprove(Request $request)
    {
        $response = Http::post('http://test.petrosmartgh.com:7777/api/payment/fleetmanager/companypool/request', [
            "requestId" =>  $request->get('requestId'),
            "fleetManagerId" => $request->get('fleetManagerId'),
            "stationId" => $request->get('stationId'),
            "paymentCode" => $request->get('paymentCode'),
            "driverId" => $request->get('driverId')
        ]);

        $responseApi = $response->json();

        if ($responseApi["code"] == "200") {
            $response_code = $responseApi["code"];
            $response_message = $responseApi["message"];
        } else {
            $response_code = $responseApi["code"];
            $response_message = $responseApi["message"];
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $responseApi, "RESPONSE_CODE" => $response_code]);
    }

    public function addFleetManagerApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        //lets check if the email exists
        if (PetrosmartFleetManagers::where("email", $request->get('email'))->exists()) {
            $creatorForm = PetrosmartFleetManagers::where("email", $request->get('email'))->first();
            $response_code = "205";
            $response_message = "Email already exists";
        }
        //lets check if the email exists
        else if (AppUsersModel::where("email", $request->get('email'))->exists()) {
            $creatorForm = AppUsersModel::where("email", $request->get('email'))->first();
            $response_code = "205";
            $response_message = "Email already exists";
        }
        //lets check if mobile number already exists
        else if (PetrosmartFleetManagers::where("mobile_number", $request->get('phoneNumber'))->exists()) {
            $creatorForm = PetrosmartFleetManagers::where("mobile_number", $request->get('mobile_number'))->first();
            $response_code = "205";
            $response_message = "Mobile number already exists";
        } else {
            $statement = DB::select("show table status like 'users'");

            $creatorForm = new PetrosmartFleetManagers();
            $creatorForm->user_id =  $statement[0]->Auto_increment;
            $creatorForm->name =  $request->get('fullName');
            $creatorForm->password =  bcrypt($request->get('password'));
            $creatorForm->email =  $request->get('email');
            $creatorForm->mobile_number =  $request->get('phoneNumber');
            $creatorForm->created_by =  $session_email;
            $creatorForm->drivers_selected =  $request->get('addFleetManagerDriverSelect');
            $creatorForm->branch_id =  $request->get('addBranchSelect');
            $creatorForm->customer_id =  $request->get('addFleetManagerCompanySelect');

            //add same data in AppUsersModel Table
            $requesterForm = new AppUsersModel();
            $requesterForm->group_id  = 3;
            $requesterForm->active = 1;
            $requesterForm->email = $request->get('email');
            $requesterForm->password = bcrypt($request->get('password'));
            $requesterForm->subscription_expiration =  Carbon::now();
            $requesterForm->loged_at =  Carbon::now();
            $requesterForm->sms_gateway_app_date =  Carbon::now();
            $requesterForm->created_at =  Carbon::now();
            $requesterForm->updated_at =  Carbon::now();


            $saveResults = 0;
            $saveResults2 = 0;
            DB::beginTransaction();
            $saveResults = $creatorForm->save();
            $saveResults2 = $requesterForm->save();
            DB::commit();

            if ($saveResults && $saveResults2) {
                $response_code = Response::HTTP_OK;
                $response_message = "User was created successfully.";
            } else {
                $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
                $response_message = "Error.Unable to save";
                DB::rollBack();
            }
        }

        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // Edit user data
    public function editFleetManagerApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  PetrosmartFleetManagers::where("user_id", $request->get('user_id'))->first();

        //set values into db
        $requesterForm->name =  $request->get('fullName');
        $requesterForm->created_by =  $session_email;
        $requesterForm->drivers_selected =  $request->get('addFleetManagerDriverSelect');
        $requesterForm->branch_id =  $request->get('addBranchSelect');
        $requesterForm->customer_id =  $request->get('addFleetManagerCompanySelect');

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->save();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User was edited successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
        }

        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }


    // Delete user data
    public function deleteFleetManagerApi(Request $request)
    {
        // delete user here 

        $requesterForm =  PetrosmartFleetManagers::where("user_id", $request->get('user_id'))->first();
        $requesterForm2 = AppUsersModel::where("id", $request->get('user_id'))->first();

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->delete();
        $saveResults2 = $requesterForm2->delete();
        DB::commit();

        if ($saveResults && $saveResults2) {
            $response_code = Response::HTTP_OK;
            $response_message = "User was deleted successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in users 
    public function getFleetManagersData(Request $request)
    {
        $model = PetrosmartFleetManagers::query();
        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {

                $query->where('email', "<>", "")
                    ->whereNotNull('email')
                    ->orderBy('created_at', 'desc');
            })->make(true);
    }

    // get all data in users 
    public function getFleetManagersRequestsDataApi(Request $request)
    {

        $userRole = strtoupper(Session::get('userRole'));
        $fleetManagerId = Session::get('fleetManagerId');

        $model = PetrosmartFleetManagerRequests::query();

        //admin user role
        if ($userRole == "ADMIN") {
            if (strtoupper($request->get('request_status')) == "PENDING") {
                return Datatables::of($model)->addIndexColumn()
                    ->filter(function ($query) use ($request) {

                        $query->where('request_id', "<>", "")
                            ->whereNotNull('request_id')
                            ->where("approval_flag", 'pending')
                            ->orderBy('created_at', 'desc');
                    })->make(true);
            }

            if (strtoupper($request->get('request_status')) == "APPROVED") {
                return Datatables::of($model)->addIndexColumn()
                    ->filter(function ($query) use ($request) {

                        $query->where('request_id', "<>", "")
                            ->whereNotNull('request_id')
                            ->where("approval_flag", 'approved')
                            ->orderBy('created_at', 'desc');
                    })->make(true);
            }
        }

        //fleet manager user role
        if ($userRole == "FLEETMANAGER") {
            if (strtoupper($request->get('request_status')) == "PENDING") {
                return Datatables::of($model)->addIndexColumn()
                    ->filter(function ($query) use ($request, $fleetManagerId) {

                        $query->where('request_id', "<>", "")
                            ->whereNotNull('request_id')
                            ->where("approval_flag", 'pending')
                            ->where("fleet_manager_id", $fleetManagerId)
                            ->orderBy('created_at', 'desc');
                    })->make(true);
            }

            if (strtoupper($request->get('request_status')) == "APPROVED") {
                return Datatables::of($model)->addIndexColumn()
                    ->filter(function ($query) use ($request, $fleetManagerId) {

                        $query->where('request_id', "<>", "")
                            ->whereNotNull('request_id')
                            ->where("approval_flag", 'approved')
                            ->where("fleet_manager_id", $fleetManagerId)
                            ->orderBy('created_at', 'desc');
                    })->make(true);
            }
        }
    }


    //get managers array

    // get fuel stations array
    public function getManagersArrayApi(Request $request)
    {
        $responseObj = [];

        $data = PetrosmartFleetManagers::where('email', "<>", "")
            ->whereNotNull('email')
            ->get();

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Managers were pulled successfully";

        return $responseObj;
    }
}
