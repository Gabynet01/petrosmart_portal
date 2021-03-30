<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartBranch;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class CompanyBranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.company.branches.dashboard');
    }

    // add branch
    public function addPetrosmartBranchApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartBranch::where("custb_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartBranch::where("custb_id", $request->get('user_id'))->first();
            $message = "Successfully edited branch";
        } else {
            $creatorForm = new PetrosmartBranch();
            $message = "Branch was created successfully";
        }

        $creatorForm->custb_id =  $request->get('user_id');
        $creatorForm->name =  $request->get('addBranchName');
        $creatorForm->customer_selected =  $request->get('addBranchCompany');
        $creatorForm->address =  $request->get('addBranchAddress');
        $creatorForm->gps =  $request->get('addBranchGps');
        $creatorForm->contact1 =  $request->get('addBranchContact1');
        $creatorForm->contact2 =  $request->get('addBranchContact2');
        $creatorForm->ccountry_id =  $request->get('addBranchCountry');
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

      // get all data in branches 
      public function getBranchUsersDataApi(Request $request)
      {
          $model = PetrosmartBranch::query();
  
          $userRole = strtoupper(Session::get('userRole'));
          if ($userRole == "ADMIN") {
              return DataTables::of($model)->addIndexColumn()
                  ->filter(function ($query) use ($request) {
  
                      $query->where('custb_id', "<>", "")
                          ->whereNotNull('custb_id')
                          ->orderBy('created_at', 'desc');
                  })->make(true);
          }
  
          if ($userRole == "MANAGER") {
              return DataTables::of($model)->addIndexColumn()
                  ->filter(function ($query) use ($request) {
  
                      $query->where('custb_id', "<>", "")
                          ->whereNotNull('custb_id')
                          ->where('created_by', Session::get('email'))
                          ->orderBy('created_at', 'desc');
                  })->make(true);
          }
  
          if ($userRole == "USER") {
              $managerEmail = Session::get('managerEmail');
  
              return DataTables::of($model)->addIndexColumn()
                  ->filter(function ($query) use ($request) {
  
                      $query->where('custb_id', "<>", "")
                          ->whereNotNull('custb_id')
                          ->where('created_by', Session::get('managerEmail'))
                          ->orderBy('created_at', 'desc');
                  })->make(true);
          }
      }
}
