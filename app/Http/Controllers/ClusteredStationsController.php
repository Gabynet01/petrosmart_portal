<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartClusteredStations;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class ClusteredStationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRole = strtoupper(Session::get('userRole'));
        return view('petrosmart_pages.fuel_stations.clustered.dashboard');
    }

    // get all data in clustered stations 
    public function getClusteredStationsDataApi(Request $request)
    {
        $model = PetrosmartClusteredStations::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cluster_id', "<>", "")
                        ->whereNotNull('cluster_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('created_by', Session::get('email'))
                        ->where('cluster_id', "<>", "")
                        ->whereNotNull('cluster_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('created_by', Session::get('managerEmail'))
                        ->where('cluster_id', "<>", "")
                        ->whereNotNull('cluster_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

      // add clustered stations
      public function addPetrosmartClusteredStationApi(Request $request)
      {
  
          // Get variables from session
          $session_email = Session::get('email');
  
          if (PetrosmartClusteredStations::where("cluster_id", $request->get('user_id'))->exists()) {
              $creatorForm = PetrosmartClusteredStations::where("cluster_id", $request->get('user_id'))->first();
              $message = "Successfully edited clustered station";
          } else {
              $creatorForm = new PetrosmartClusteredStations();
              $message = "Clustered station was created successfully";
          }
  
          $creatorForm->cluster_id =  $request->get('user_id');
          $creatorForm->name =  $request->get('name');
          $creatorForm->fuel_stations_list =  $request->get('stations');
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
  
}
