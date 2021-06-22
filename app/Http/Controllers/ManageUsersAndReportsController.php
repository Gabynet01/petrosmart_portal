<?php

namespace App\Http\Controllers;

use App\PetrosmartOmcUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;

class ManageUsersAndReportsController extends Controller
{
    // Load the manage application users dashboard
    public function manageApplicationUsers()
    {
        return view('petrosmart_pages.omc_users.manageAppUsers');
    }


    public function addAdminUserApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        //lets check if the email exists
        if (PetrosmartOmcUsers::where("email", $request->get('email'))->exists()) {
            $creatorForm = PetrosmartOmcUsers::where("email", $request->get('email'))->first();
            $response_code = "205";
            $response_message = "Email already exists";
        } else {
            $creatorForm = new PetrosmartOmcUsers();
            $creatorForm->user_id =  $request->get('user_id');
            $creatorForm->name =  $request->get('fullName');
            $creatorForm->password =  bcrypt($request->get('password'));
            $creatorForm->email =  $request->get('email');
            $creatorForm->created_by =  $session_email;

            $saveResults = 0;
            DB::beginTransaction();
            $saveResults = $creatorForm->save();
            DB::commit();

            if ($saveResults) {
                $response_code = Response::HTTP_OK;
                $response_message = "User was created successfully.";
            } else {
                $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
                $response_message = "Error.Unable to save";
            }
        }

        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // Edit user data
    public function editAdminUserApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  PetrosmartOmcUsers::where("user_id", $request->get('user_id'))->first();

        //set values into db
        $requesterForm->name =  $request->get('fullName');
        $requesterForm->created_by =  $session_email;

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
    public function deleteAdminUserApi(Request $request)
    {
        // delete user here 

        $requesterForm =  PetrosmartOmcUsers::where("user_id", $request->get('user_id'))->first();

        $saveResults = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->delete();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = "User was deleted successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in users 
    public function getAdminUsersData(Request $request)
    {
        $model = PetrosmartOmcUsers::query();
        return Datatables::of($model)->addIndexColumn()
            ->filter(function ($query) use ($request) {

                $query->where('email', "<>", "")
                    ->whereNotNull('email')
                    ->orderBy('created_at', 'desc');
            })->make(true);
    }
}
