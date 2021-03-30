<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartNotifications;
use App\PetrosmartNotificationsAssignment;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class PetrosmartNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('petrosmart_pages.notifications.dashboard');
    }

    // add notifications
    public function addPetrosmartNotificationApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartNotifications::where("notify_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartNotifications::where("notify_id", $request->get('user_id'))->first();
            $message = "Successfully edited notification";
        } else {
            $creatorForm = new PetrosmartNotifications();
            $message = "Notification was created successfully";
        }

        $creatorForm->notify_id =  $request->get('user_id');
        $creatorForm->heading =  $request->get('mainHeading');
        $creatorForm->sub_headings =  $request->get('subHeading');
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
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }


    // assign notifications
    public function assignPetrosmartNotificationApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        // get all the variables pushed from the JS
        $allManagerList = $request->get('manager');
        $allDriverList = $request->get('driver');

        if (PetrosmartNotificationsAssignment::where("assign_id", "notifyAssignID")->exists()) {
            $creatorForm = PetrosmartNotificationsAssignment::where("assign_id", "notifyAssignID")->first();
        } else {
            $creatorForm = new PetrosmartNotificationsAssignment;
        }

        $message = "Successfully assigned notifications";

        $creatorForm->assign_id = "notifyAssignID";
        $creatorForm->manager = $allManagerList;
        $creatorForm->driver = $allDriverList;
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
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }


    // Pull all notifications data
    public function getNotificationsDataApi(Request $request)
    {
        $model = PetrosmartNotifications::query();
        $userRole = strtoupper(Session::get('userRole'));

        if ($userRole == "ADMIN") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('notify_id', "<>", "")
                        ->whereNotNull('notify_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    public function getNotificationArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));

        if ($userRole == "ADMIN") {
            $data = PetrosmartNotifications::where('notify_id', "<>", "")
                ->whereNotNull('notify_id')
                // ->where('created_by', Session::get('email'))
                ->get();

            $assignedData = PetrosmartNotificationsAssignment::where('assign_id', "<>", "")
                ->whereNotNull('assign_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['ASSIGNED_DATA'] = $assignedData;
        $responseObj['RESPONSE_MESSAGE'] = "Notifications were pulled successfully";

        return $responseObj;
    }

    public function getNotificationAssignmentArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));

        if ($userRole == "ADMIN") {
            $data = PetrosmartNotificationsAssignment::where('assign_id', "<>", "")
                ->whereNotNull('assign_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Notifications were pulled successfully";

        return $responseObj;
    }
}
