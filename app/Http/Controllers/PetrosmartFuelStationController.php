<?php

namespace App\Http\Controllers;

use App\DevicesModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartBranch;
use App\PetrosmartClusteredStations;
use App\PetrosmartContact;
use App\PetrosmartCountries;
use App\PetrosmartCustomers;
use App\PetrosmartDrivers;
use App\PetrosmartFuelAttendants;
use App\PetrosmartFuelPayment;
use App\PetrosmartFuelPOS;
use App\PetrosmartFuelPurchase;
use App\PetrosmartFuelStation;
use App\PetrosmartFuelStationWallet;
use App\PetrosmartFuelVouchers;
use App\PetrosmartIndustries;
use App\PetrosmartNotifications;
use App\PetrosmartOMC;
use App\PetrosmartVehicles;
use App\PetrosmartVoucherList;
use App\PetrosmartWallet;
use App\UserDriversModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class PetrosmartFuelStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // manage content based on role

        $userRole = strtoupper(Session::get('userRole'));

        if ($userRole == "ADMIN" || $userRole == "OMC") {

            $omc = PetrosmartOMC::all()->count();
            $fuelStations = PetrosmartFuelStation::all()->count();
            $clusteredStations = PetrosmartClusteredStations::all()->count();
            $attendants = PetrosmartFuelAttendants::all()->count();
            $pos = PetrosmartFuelPOS::all()->count();
            $payments = PetrosmartFuelPayment::all()->count();
            $purchase = PetrosmartFuelPurchase::all()->count();
            $wallet = PetrosmartFuelStationWallet::all()->count();
            // $drivers = PetrosmartDrivers::all()->count();
            // $vehicles = PetrosmartVehicles::all()->count();

        }

        if ($userRole == "MANAGER") {

            $omc = PetrosmartOMC::all()->where('created_by', Session::get('email'))->count();
            $fuelStations = PetrosmartFuelStation::all()->where('created_by', Session::get('email'))->count();
            $attendants = PetrosmartFuelAttendants::all()->where('created_by', Session::get('email'))->count();
            $pos = PetrosmartFuelPOS::all()->where('created_by', Session::get('email'))->count();
            $payments = PetrosmartFuelPayment::all()->where('created_by', Session::get('email'))->count();
            $purchase = PetrosmartFuelPurchase::all()->where('created_by', Session::get('email'))->count();
            $wallet = PetrosmartFuelStationWallet::all()->where('created_by', Session::get('email'))->count();
            // $drivers = PetrosmartDrivers::all()->count();
            // $vehicles = PetrosmartVehicles::all()->count();

        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $omc = PetrosmartOMC::all()->where('created_by', $managerEmail)->count();
            $fuelStations = PetrosmartFuelStation::all()->where('created_by', $managerEmail)->count();
            $attendants = PetrosmartFuelAttendants::all()->where('created_by', $managerEmail)->count();
            $pos = PetrosmartFuelPOS::all()->where('created_by', $managerEmail)->count();
            $payments = PetrosmartFuelPayment::all()->where('created_by', $managerEmail)->count();
            $purchase = PetrosmartFuelPurchase::all()->where('created_by', $managerEmail)->count();
            $wallet = PetrosmartFuelStationWallet::all()->where('created_by', $managerEmail)->count();
            // $drivers = PetrosmartDrivers::all()->count();
            // $vehicles = PetrosmartVehicles::all()->count();

        }


        // dd(Session::get('email'));
        return view('petrosmart_pages.fuel_station.dashboard')
            ->with("omc", $omc)
            ->with("fuelStations", $fuelStations)
            ->with("clusteredStations", $clusteredStations)
            ->with("attendants", $attendants)
            ->with("pos", $pos)
            ->with("payments", $payments)
            ->with("purchase", $purchase)
            ->with("wallet", $wallet);
        // ->with("drivers", $drivers)
        // ->with("vehicles", $vehicles);
    }

    // add wallet
    public function addFuelStationWalletApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelStationWallet::where("custw_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelStationWallet::where("custw_id", $request->get('user_id'))->first();
            $message = "Successfully edited wallet";
        } else {
            $creatorForm = new PetrosmartFuelStationWallet();
            $message = "Wallet was created successfully";
        }

        $creatorForm->custw_id =  $request->get('user_id');
        $creatorForm->fuel_station_id =  $request->get('addStationWallet');
        $creatorForm->telco =  $request->get('addTelco');
        $creatorForm->wallet_num =  $request->get('addWalletNum');
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

    // add wallet
    public function deactivateDriverVoucherApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartVoucherList::where("voucher_id", $request->get('voucherId'))->exists()) {
            $creatorForm = PetrosmartVoucherList::where("voucher_id", $request->get('voucherId'))->first();
            $message = "Successfully deactivated voucher";
        } 

        $creatorForm->usage_status =  "DEACTIVATED";
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

    // add fuel vouchers
    public function addPetrosmartFuelVouchersApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelVouchers::where("fv_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelVouchers::where("fv_id", $request->get('user_id'))->first();
            $message = "Successfully edited voucher";
        } else {
            $creatorForm = new PetrosmartFuelVouchers();
            $message = "Voucher was created successfully";

            //    we need to decode the json array string so that we can push it into the db
            $voucherList = json_decode($request->get('driverVouchersList'), true);

            //loop through the list and create the 
            foreach ($voucherList as $voucher) {
                $voucherForm = new PetrosmartVoucherList();
                $voucherForm->parent_voucher_id = $voucher["parent_voucher_id"];
                $voucherForm->voucher_id = $voucher["voucher_id"];
                $voucherForm->driver_id = $voucher["driver_id"];
                $voucherForm->voucher_code = $voucher["voucher_code"];
                $voucherForm->voucher_type = $voucher["voucher_type"];
                $voucherForm->amount = $voucher["unit_amount"];
                $voucherForm->balance = $voucher["unit_amount"];
                $voucherForm->usage_status = "unused";
                $voucherForm->expiry_date = Carbon::parse($voucher["expiry_date"])->utc();
                $voucherForm->created_by =  $session_email;

                //save the form to db
                $saveVoucherResults = 0;
                DB::beginTransaction();
                $saveVoucherResults = $voucherForm->save();
                DB::commit();
            }
        }

        // check if the voucher forms were saved before executing the others
        if ($saveVoucherResults) {
            if ($request->get('addVoucherExpiryDate') !== NULL) {
                $expiry_date =  Carbon::parse($request->get('addVoucherExpiryDate'))->utc();
                $creatorForm->expiry_date =  $expiry_date;
            }

            $creatorForm->fv_id =  $request->get('user_id');
            $creatorForm->customer =  $request->get('addCustomerContact');
            $creatorForm->voucher_type =  $request->get('addVoucherType');
            $creatorForm->unit_amount =  $request->get('addVoucherAmount');
            $creatorForm->amount =  $request->get('totalAmount');
            $creatorForm->voucher_code =  $request->get('addVoucherCode');
            $creatorForm->branch_id =  $request->get('addVoucherCompanyBranchSelect');
            $creatorForm->drivers =  $request->get('addVoucherCompanyDriverBranchSelect');
            $creatorForm->usage_status =  "unused";
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
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollBack();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in fuel vouchers 
    public function getFuelVouchersDataApi(Request $request)
    {
        $model = PetrosmartFuelVouchers::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fv_id', "<>", "")
                        ->whereNotNull('fv_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fv_id', "<>", "")
                        ->whereNotNull('fv_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fv_id', "<>", "")
                        ->whereNotNull('fv_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // get all data in fuel vouchers 
    public function getDriverFuelVouchersDataApi(Request $request)
    {
        $model = PetrosmartVoucherList::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('parent_voucher_id', "<>", "")
                        ->whereNotNull('parent_voucher_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('parent_voucher_id', "<>", "")
                        ->whereNotNull('parent_voucher_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('parent_voucher_id', "<>", "")
                        ->whereNotNull('parent_voucher_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }


    // add fuel POS
    public function addPetrosmartFuelPosApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');
        if (PetrosmartFuelPOS::where("pos_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelPOS::where("pos_id", $request->get('user_id'))->first();
            $message = "Successfully edited pos";
        } else {
            $creatorForm = new PetrosmartFuelPOS();
            $message = "POS was created successfully";
        }

        $creatorForm->pos_id =  $request->get('user_id');
        // $creatorForm->station_id =  $request->get('addFuelStationsPos');
        $creatorForm->make =  $request->get('addPosMake');
        $creatorForm->model =  $request->get('addPosModel');
        $creatorForm->serial_no =  $request->get('addPosSerial');
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

    // get all data in fuel Pos 
    public function getFuelPosDataApi(Request $request)
    {
        $model = PetrosmartFuelPOS::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('pos_id', "<>", "")
                        ->whereNotNull('pos_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('pos_id', "<>", "")
                        ->whereNotNull('pos_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('pos_id', "<>", "")
                        ->whereNotNull('pos_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // add OMC
    public function addPetrosmartOmcApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartOMC::where("omc_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartOMC::where("omc_id", $request->get('user_id'))->first();
            $message = "Successfully edited omc";
        } else {
            $creatorForm = new PetrosmartOMC();
            $message = "OMC was created successfully";
        }

        $creatorForm->omc_id =  $request->get('user_id');
        $creatorForm->name =  $request->get('addOmcName');
        $creatorForm->address =  $request->get('addOmcAddress');
        $creatorForm->country =  $request->get('addOmcCountry');
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

    // get all data in OMC 
    public function getOmcDataApi(Request $request)
    {
        $model = PetrosmartOMC::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('omc_id', "<>", "")
                        ->whereNotNull('omc_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('omc_id', "<>", "")
                        ->whereNotNull('omc_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('omc_id', "<>", "")
                        ->whereNotNull('omc_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // add Payment Api
    public function addPetrosmartPaymentApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelPayment::where("fpay_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelPayment::where("fpay_id", $request->get('user_id'))->first();
            $message = "Successfully edited payment";
        } else {
            $creatorForm = new PetrosmartFuelPayment();
            $message = "Payment was created successfully";
        }

        // first lets check which payment type it is
        if (strtoupper($request->get('addPaymentType')) == "COMPANY") {
            $creatorForm->company_amount =  $request->get('addCompanyAmount');
        }

        if (strtoupper($request->get('addPaymentType')) == "VOUCHER") {
            $creatorForm->voucher_type =  $request->get('addVoucherType');
            $creatorForm->voucher_id =  $request->get('addCustomerVoucherCode');

            // lets check the voucher amount against the entered amount
            if (strtoupper($request->get('addVoucherType')) == "SINGLE USE") {
                // lets just check if the voucher exists
                if (PetrosmartFuelVouchers::where("fv_id", $request->get('addCustomerVoucherCode'))->exists()) {
                    $voucher = PetrosmartFuelVouchers::where("fv_id", $request->get('addCustomerVoucherCode'))->first();

                    //    lets check the balance left so as to prevent it usage again
                    if ($voucher->balance_left == $voucher->amount) {
                        $response_code = "204";
                        $response_message = "Single voucher amount exhausted. Choose another voucher";
                        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $voucher, "RESPONSE_CODE" => $response_code]);
                    } else {
                        $voucher->balance_left = $voucher->amount;
                    }
                }
            }

            // lets check the voucher amount against the entered amount
            if (strtoupper($request->get('addVoucherType')) == "MULTIPLE USE") {
                $creatorForm->voucher_amount =  $request->get('addMultipleUseAmount');

                // lets just check if the voucher exists
                if (PetrosmartFuelVouchers::where("fv_id", $request->get('addCustomerVoucherCode'))->exists()) {
                    $voucher = PetrosmartFuelVouchers::where("fv_id", $request->get('addCustomerVoucherCode'))->first();

                    //    lets check the balance left so as to prevent it usage again

                    // if the balance left is the same as voucher amount
                    if ($voucher->balance_left == $voucher->amount) {
                        $response_code = "204";
                        $response_message = "Multiple usage voucher amount exhausted";
                        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $voucher, "RESPONSE_CODE" => $response_code]);
                    }

                    if ($voucher->balance_left != $voucher->amount) {

                        if ($voucher->balance_left == null) {
                            $voucher->balance_left = "0";
                        }

                        if ($voucher->balance_left != null) {
                            $voucher->balance_left = $voucher->balance_left;
                        }

                        $totalamount = $voucher->balance_left + $request->get('addMultipleUseAmount');

                        if ($totalamount > $voucher->amount) {
                            $response_code = "204";
                            $response_message = "Amount entered is more than balance left";
                            return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $voucher, "RESPONSE_CODE" => $response_code]);
                        }

                        $voucher->balance_left = $totalamount;
                    }
                }
            }
        }


        // General variables
        $creatorForm->fpay_id =  $request->get('user_id');
        $creatorForm->payment_type =  $request->get('addPaymentType');
        $creatorForm->customer =  $request->get('addPaymentCustomer');
        $creatorForm->station_id =  $request->get('addFuelStationsPayment');
        $creatorForm->payment_date =  Carbon::now();
        $creatorForm->driver_selected =  $request->get('addPaymentDriver');
        $creatorForm->created_by =  $session_email;

        $saveResults = 0;
        $voucherResults = 0;
        DB::beginTransaction();
        $saveResults = $creatorForm->save();
        if (strtoupper($request->get('addPaymentType')) == "VOUCHER") {
            $voucherResults = $voucher->save();
        }
        DB::commit();

        if ($saveResults || $voucherResults) {
            $response_code = Response::HTTP_OK;
            $response_message = $message;
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to save";
            DB::rollback();
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $creatorForm, "RESPONSE_CODE" => $response_code]);
    }

    // get all data in Payment 
    public function getPaymentDataApi(Request $request)
    {
        $model = PetrosmartFuelPayment::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fpay_id', "<>", "")
                        ->whereNotNull('fpay_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fpay_id', "<>", "")
                        ->whereNotNull('fpay_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fpay_id', "<>", "")
                        ->whereNotNull('fpay_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }


    // add Purchase Api
    public function addPetrosmartPurchaseApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartFuelPurchase::where("fp_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartFuelPurchase::where("fp_id", $request->get('user_id'))->first();
            $message = "Successfully edited purchase";
        } else {
            $creatorForm = new PetrosmartFuelPurchase();
            $message = "Purchase was created successfully";
        }

        $creatorForm->fp_id =  $request->get('user_id');
        $creatorForm->customer =  $request->get('addPurchaseCustomer');
        $creatorForm->station_id =  $request->get('addFuelStationsPurchase');
        $creatorForm->purchase_date =  Carbon::now();
        $creatorForm->amount =  $request->get('addPurchaseAmount');
        $creatorForm->purchase_items =  $request->get('addPurchaseItems');
        $creatorForm->driver_selected =  $request->get('addPurchaseDriver');
        $creatorForm->driver_vehicle_selected =  $request->get('addPurchaseVehicle');
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

    // get all data in purchase 
    public function getPurchaseDataApi(Request $request)
    {
        $model = PetrosmartFuelPurchase::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fp_id', "<>", "")
                        ->whereNotNull('fp_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fp_id', "<>", "")
                        ->whereNotNull('fp_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            // $managerEmail = Session::get('managerEmail');
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('fp_id', "<>", "")
                        ->whereNotNull('fp_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
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

    // Delete driver data
    public function deleteDriverUserApi(Request $request)
    {
        // delete inventory here 

        $requesterForm = PetrosmartDrivers::where("driver_id", $request->get('driver_id'))->first();
        $requesterForm2 = UserDriversModel::where("id", $request->get('driver_id'))->first();

        $saveResults = 0;
        $saveResults2 = 0;
        DB::beginTransaction();
        $saveResults = $requesterForm->delete();
        $saveResults2 = $requesterForm2->delete();
        DB::commit();

        if ($saveResults && $saveResults2) {
            $response_code = Response::HTTP_OK;
            $response_message = "Driver was deleted successfully";
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to delete";
        }
        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
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


    // get fuel stations array
    public function getFuelStationsArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartFuelStation::where('station_id', "<>", "")
                ->whereNotNull('station_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartFuelStation::where('station_id', "<>", "")
                ->whereNotNull('station_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartFuelStation::where('station_id', "<>", "")
                ->whereNotNull('station_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Fuel Stations were pulled successfully";

        return $responseObj;
    }

    // get cluster array
    public function getClusteredArrayApi(Request $request)
    {
        $responseObj = [];
        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartClusteredStations::where('cluster_id', "<>", "")
                ->whereNotNull('cluster_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartClusteredStations::where('cluster_id', "<>", "")
                ->whereNotNull('cluster_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartClusteredStations::where('cluster_id', "<>", "")
                ->whereNotNull('cluster_id')
                // ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Clusters were pulled successfully";

        return $responseObj;
    }

    // get omc(Oil Marketing Company array
    public function getOmcArrayApi(Request $request)
    {
        $responseObj = [];
        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartOMC::where('omc_id', "<>", "")
                ->whereNotNull('omc_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartOMC::where('omc_id', "<>", "")
                ->whereNotNull('omc_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartOMC::where('omc_id', "<>", "")
                ->whereNotNull('omc_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "OMC were pulled successfully";

        return $responseObj;
    }

    // get all data in wallets 
    public function getWalletFuelStationDataApi(Request $request)
    {
        $model = PetrosmartFuelStationWallet::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custw_id', "<>", "")
                        ->whereNotNull('custw_id')

                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custw_id', "<>", "")
                        ->whereNotNull('custw_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custw_id', "<>", "")
                        ->whereNotNull('custw_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }


    // get pos array
    public function getPosArrayApi(Request $request)
    {
        $responseObj = [];
        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartFuelPOS::where('pos_id', "<>", "")
                ->whereNotNull('pos_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartFuelPOS::where('pos_id', "<>", "")
                ->whereNotNull('pos_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartFuelPOS::where('pos_id', "<>", "")
                ->whereNotNull('pos_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "POS were pulled successfully";

        return $responseObj;
    }

    // get vouchers array
    public function getVouchersArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartFuelVouchers::where('fv_id', "<>", "")
                ->whereNotNull('fv_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartFuelVouchers::where('fv_id', "<>", "")
                ->whereNotNull('fv_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');
            $data = PetrosmartFuelVouchers::where('fv_id', "<>", "")
                ->whereNotNull('fv_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Fuel Vouchers were pulled successfully";

        return $responseObj;
    }


    // get devices array
    public function getDevicesArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = DevicesModel::where('id', "<>", "")
                ->whereNotNull('id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = DevicesModel::where('id', "<>", "")
                ->whereNotNull('id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');
            $data = DevicesModel::where('id', "<>", "")
                ->whereNotNull('id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Devices were pulled successfully";

        return $responseObj;
    }

    // get drivers array
    public function getDriverArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartDrivers::where('driver_id', "<>", "")
                ->whereNotNull('driver_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartDrivers::where('driver_id', "<>", "")
                ->whereNotNull('driver_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');
            $data = PetrosmartDrivers::where('driver_id', "<>", "")
                ->whereNotNull('driver_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Drivers were pulled successfully";

        return $responseObj;
    }


    // get vehicles array
    public function getVehiclesArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartVehicles::where('veh_id', "<>", "")
                ->whereNotNull('veh_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartVehicles::where('veh_id', "<>", "")
                ->whereNotNull('veh_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartVehicles::where('veh_id', "<>", "")
                ->whereNotNull('veh_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Vehicles were pulled successfully";

        return $responseObj;
    }

    // get customer voucher array
    public function getCustomerVouchersApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN" || $userRole == "OMC") {
            $data = PetrosmartFuelVouchers::where(strtoupper('customer'), strtoupper($request->get('customerId')))
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartFuelVouchers::where(strtoupper('customer'), strtoupper($request->get('customerId')))
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $data = PetrosmartFuelVouchers::where(strtoupper('customer'), strtoupper($request->get('customerId')))
                ->where('created_by', Session::get('managerEmail'))
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Customer Vouchers were pulled successfully";

        return $responseObj;
    }

    // get driver vehicles array
    public function getDriverVehiclesApi(Request $request)
    {
        $responseObj = [];
        $data = PetrosmartDrivers::where(strtoupper('driver_id'), strtoupper($request->get('driverId')))
            // ->where('created_by', Session::get('email'))
            ->first();

        $stringVehicleIds = explode(',', $data->vehicles_selected);

        foreach ($stringVehicleIds as $vehicle) {
            $data = PetrosmartVehicles::where("veh_id", $vehicle)->first();

            $pages_array[] = (object) array('veh_id' => $vehicle, 'name' => $data->name);
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $pages_array;
        $responseObj['RESPONSE_MESSAGE'] = "Driver vehicles were pulled successfully";

        return $responseObj;
    }



    // get voucher usage type array
    public function getVoucherUsageTypeApi(Request $request)
    {
        $responseObj = [];
        $data = PetrosmartFuelVouchers::where(strtoupper('fv_id'), strtoupper($request->get('voucherId')))
            // ->where('created_by', Session::get('email'))
            ->first();

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Voucher type pulled successfully";

        return $responseObj;
    }

    // Delete global data
    public function deleteGlobalApi(Request $request)
    {
        // delete vehicles 
        if ($request->get('deleteType') == "vehicle") {
            $requesterForm = PetrosmartVehicles::where("veh_id", $request->get('deleteId'))->first();
            $message = "Vehicle was deleted successfully";
        }

        // delete purchase
        if ($request->get('deleteType') == "purchase") {
            $requesterForm = PetrosmartFuelPurchase::where("fp_id", $request->get('deleteId'))->first();
            $message = "Purchase was deleted successfully";
        }

        // delete payment
        if ($request->get('deleteType') == "payment") {
            $requesterForm = PetrosmartFuelPayment::where("fpay_id", $request->get('deleteId'))->first();
            $message = "Payment was deleted successfully";
        }

        // delete omc
        if ($request->get('deleteType') == "omc") {
            $requesterForm = PetrosmartOMC::where("omc_id", $request->get('deleteId'))->first();
            $message = "OMC was deleted successfully";
        }

        // delete pos
        if ($request->get('deleteType') == "pos") {
            $requesterForm = PetrosmartFuelPOS::where("pos_id", $request->get('deleteId'))->first();
            $message = "POS was deleted successfully";
        }

        // delete main voucher and also delete the ones that have been created for any user
        if ($request->get('deleteType') == "voucher") {

            $requesterForm1 = PetrosmartFuelVouchers::where("fv_id", $request->get('deleteId'))->first();
            $requesterForm2 = PetrosmartVoucherList::where("parent_voucher_id", $request->get('deleteId'))->delete();
            $message = "Voucher was deleted successfully";

            $saveResults1 = 0;

            DB::beginTransaction();
            $saveResults1 = $requesterForm1->delete();

            DB::commit();

            if ($saveResults1 && $requesterForm2) {
                $response_code = Response::HTTP_OK;
                $response_message = $message;
            } else {
                $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
                $response_message = "Error.Unable to delete";
                DB::rollBack();
            }
            return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm1, "RESPONSE_CODE" => $response_code]);
        }

        // delete attendants
        if ($request->get('deleteType') == "attendant") {
            $requesterForm = PetrosmartFuelAttendants::where("att_id", $request->get('deleteId'))->first();
            $message = "Attendant was deleted successfully";
        }

        // delete stations
        if ($request->get('deleteType') == "station") {
            $requesterForm = PetrosmartFuelStation::where("station_id", $request->get('deleteId'))->first();
            $message = "Station was deleted successfully";
        }

        // delete clustered stations
        if ($request->get('deleteType') == "cluster") {
            $requesterForm = PetrosmartClusteredStations::where("cluster_id", $request->get('deleteId'))->first();
            $message = "Clustered Station was deleted successfully";
        }


        // FOR PETROSMART CUSTOMERS CONTROLLER

        // delete industry
        if ($request->get('deleteType') == "industry") {
            $requesterForm = PetrosmartIndustries::where("industry_id", $request->get('deleteId'))->first();
            $message = "Industry was deleted successfully";
        }

        // delete wallet
        if ($request->get('deleteType') == "wallet") {
            $requesterForm = PetrosmartWallet::where("custw_id", $request->get('deleteId'))->first();
            $message = "Wallet was deleted successfully";
        }

        // delete wallet fuel station
        if ($request->get('deleteType') == "walletFuelStation") {
            $requesterForm = PetrosmartFuelStationWallet::where("custw_id", $request->get('deleteId'))->first();
            $message = "Wallet was deleted successfully";
        }

        // delete country
        if ($request->get('deleteType') == "country") {
            $requesterForm = PetrosmartCountries::where("ccountry_id", $request->get('deleteId'))->first();
            $message = "Country was deleted successfully";
        }

        // delete contact
        if ($request->get('deleteType') == "contact") {
            $requesterForm = PetrosmartContact::where("custc_id", $request->get('deleteId'))->first();
            $message = "Contact was deleted successfully";
        }

        // delete branch
        if ($request->get('deleteType') == "branch") {
            $requesterForm = PetrosmartBranch::where("custb_id", $request->get('deleteId'))->first();
            $message = "Branch was deleted successfully";
        }

        // delete customer
        if ($request->get('deleteType') == "customer") {
            $requesterForm = PetrosmartCustomers::where("cust_id", $request->get('deleteId'))->first();
            $message = "Customer was deleted successfully";
        }


        // delete notification
        if ($request->get('deleteType') == "notification") {
            $requesterForm = PetrosmartNotifications::where("notify_id", $request->get('deleteId'))->first();
            $message = "Notification was deleted successfully";
        }



        $saveResults = 0;

        DB::beginTransaction();
        $saveResults = $requesterForm->delete();
        DB::commit();

        if ($saveResults) {
            $response_code = Response::HTTP_OK;
            $response_message = $message;
        } else {
            $response_code = Response::HTTP_SERVICE_UNAVAILABLE;
            $response_message = "Error.Unable to delete";
        }

        return response()->json(["RESPONSE_MESSAGE" => $response_message, "RESPONSE_DATA" => $requesterForm, "RESPONSE_CODE" => $response_code]);
    }
}
