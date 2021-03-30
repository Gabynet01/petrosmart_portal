<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PetrosmartBranch;
use App\PetrosmartContact;
use App\PetrosmartCountries;
use App\PetrosmartCustomers;
use App\PetrosmartDrivers;
use App\PetrosmartFuelPayment;
use App\PetrosmartFuelVouchers;
use App\PetrosmartIndustries;
use App\PetrosmartVehicles;
use App\PetrosmartWallet;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;

class PetrosmartCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userRole = strtoupper(Session::get('userRole'));

        if ($userRole == "ADMIN") {

            $customers = PetrosmartCustomers::all()->count();
            $branches = PetrosmartBranch::all()->count();
            $contacts = PetrosmartContact::all()->count();
            $countries = PetrosmartCountries::all()->count();
            $vouchers = PetrosmartFuelVouchers::all()->count();
            $payments = PetrosmartFuelPayment::all()->count();
            $wallets = PetrosmartWallet::all()->count();
            $industries = PetrosmartIndustries::all()->count();
            $drivers = PetrosmartDrivers::all()->count();
            $vehicles = PetrosmartVehicles::all()->count();
        }

        if ($userRole == "MANAGER") {

            $customers = PetrosmartCustomers::all()->where('created_by', Session::get('email'))->count();
            $branches = PetrosmartBranch::all()->where('created_by', Session::get('email'))->count();
            $contacts = PetrosmartContact::all()->where('created_by', Session::get('email'))->count();
            $countries = PetrosmartCountries::all()->where('created_by', Session::get('email'))->count();
            $vouchers = PetrosmartFuelVouchers::all()->where('created_by', Session::get('email'))->count();
            $payments = PetrosmartFuelPayment::all()->where('created_by', Session::get('email'))->count();
            $wallets = PetrosmartWallet::all()->where('created_by', Session::get('email'))->count();
            $industries = PetrosmartIndustries::all()->where('created_by', Session::get('email'))->count();
            $drivers = PetrosmartDrivers::all()->where('created_by', Session::get('email'))->count();
            $vehicles = PetrosmartVehicles::all()->where('created_by', Session::get('email'))->count();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $customers = PetrosmartCustomers::all()->where('created_by', $managerEmail)->count();
            $branches = PetrosmartBranch::all()->where('created_by', $managerEmail)->count();
            $contacts = PetrosmartContact::all()->where('created_by', $managerEmail)->count();
            $countries = PetrosmartCountries::all()->where('created_by', $managerEmail)->count();
            $vouchers = PetrosmartFuelVouchers::all()->where('created_by', $managerEmail)->count();
            $payments = PetrosmartFuelPayment::all()->where('created_by', $managerEmail)->count();
            $wallets = PetrosmartWallet::all()->where('created_by', $managerEmail)->count();
            $industries = PetrosmartIndustries::all()->where('created_by', $managerEmail)->count();
            $drivers = PetrosmartDrivers::all()->where('created_by', $managerEmail)->count();
            $vehicles = PetrosmartVehicles::all()->where('created_by', $managerEmail)->count();
        }

        return view('petrosmart_pages.customers.dashboard')
            ->with("customers", $customers)
            ->with("branches", $branches)
            ->with("contacts", $contacts)
            ->with("countries", $countries)
            ->with("vouchers", $vouchers)
            ->with("payments", $payments)
            ->with("wallets", $wallets)
            ->with("industries", $industries)
            ->with("drivers", $drivers)
            ->with("vehicles", $vehicles);
    }

    // add customer
    public function addPetrosmartCustomerApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartCustomers::where("cust_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartCustomers::where("cust_id", $request->get('user_id'))->first();
            $message = "Successfully edited customer";
        } else {
            $creatorForm = new PetrosmartCustomers();
            $message = "Customer was created successfully";
        }

        $creatorForm->cust_id =  $request->get('user_id');
        $creatorForm->address =  $request->get('address');
        $creatorForm->industry =  $request->get('industry');
        $creatorForm->full_name =  $request->get('full_name');
        $creatorForm->gps =  $request->get('gps');
        $creatorForm->country =  $request->get('country');
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

    // add contact
    public function addPetrosmartContactApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartContact::where("custc_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartContact::where("custc_id", $request->get('user_id'))->first();
            $message = "Successfully edited contact";
        } else {
            $creatorForm = new PetrosmartContact();
            $message = "Contact was created successfully";
        }

        $creatorForm->custc_id =  $request->get('user_id');
        $creatorForm->cust_id =  $request->get('addCustomerContact');
        $creatorForm->full_name =  $request->get('addCustomerContact');
        $creatorForm->email =  $request->get('addEmailContact');
        $creatorForm->tel =  $request->get('addTelephoneContact');
        $creatorForm->mob =  $request->get('addMobileContact');
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

    // add industries
    public function addPetrosmartIndustryApi(Request $request)
    {
        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartIndustries::where("industry_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartIndustries::where("industry_id", $request->get('user_id'))->first();
            $message = "Successfully edited industry";
        } else {
            $creatorForm = new PetrosmartIndustries();
            $message = "Industry was created successfully";
        }

        $creatorForm->industry_id =  $request->get('user_id');
        $creatorForm->industry_name =  $request->get('addIndustryName');
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

    // add countries
    public function addPetrosmartCountryApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartCountries::where("ccountry_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartCountries::where("ccountry_id", $request->get('user_id'))->first();
            $message = "Successfully edited country";
        } else {
            $creatorForm = new PetrosmartCountries();
            $message = "Country was created successfully";
        }

        $creatorForm->ccountry_id =  $request->get('user_id');
        $creatorForm->country =  $request->get('addCountryName');
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

    // add wallet
    public function addPetrosmartWalletApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        if (PetrosmartWallet::where("custw_id", $request->get('user_id'))->exists()) {
            $creatorForm = PetrosmartWallet::where("custw_id", $request->get('user_id'))->first();
            $message = "Successfully edited wallet";
        } else {
            $creatorForm = new PetrosmartWallet();
            $message = "Wallet was created successfully";
        }

        $creatorForm->custw_id =  $request->get('user_id');
        $creatorForm->custb_id =  $request->get('addBranchSelect');
        $creatorForm->customer_selected =  $request->get('addCompanyWallet');
        $creatorForm->telco =  $request->get('addTelco');
        $creatorForm->wallet_num =  $request->get('addWalletNum');
        $creatorForm->authorization_key =  $request->get('addAuthKey');
        $creatorForm->merchant_token =  $request->get('addMerchantToken');
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

    // get all industries
    public function getIndustriesArrayApi(Request $request)
    {
        $userRole = strtoupper(Session::get('userRole'));

        $responseObj = [];

        if ($userRole == "ADMIN") {
            $data = PetrosmartIndustries::where('industry_id', "<>", "")
                ->whereNotNull('industry_id')
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartIndustries::where('industry_id', "<>", "")
                ->whereNotNull('industry_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartIndustries::where('industry_id', "<>", "")
                ->whereNotNull('industry_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }


        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Industries were pulled successfully";

        return $responseObj;
    }

    // get all countries
    public function getCountriesArrayApi(Request $request)
    {

        $userRole = strtoupper(Session::get('userRole'));

        $responseObj = [];

        if ($userRole == "ADMIN") {
            $data = PetrosmartCountries::where('ccountry_id', "<>", "")
                ->whereNotNull('ccountry_id')
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartCountries::where('ccountry_id', "<>", "")
                ->whereNotNull('ccountry_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartCountries::where('ccountry_id', "<>", "")
                ->whereNotNull('ccountry_id')
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Countries were pulled successfully";

        return $responseObj;
    }

    // get all customers
    public function getCustomersArrayApi(Request $request)
    {

        $responseObj = [];
        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {
            $data = PetrosmartCustomers::where('cust_id', "<>", "")
                ->whereNotNull('cust_id')
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartCustomers::where('cust_id', "<>", "")
                ->whereNotNull('cust_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartCustomers::where('cust_id', "<>", "")
                ->whereNotNull('cust_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Customers were pulled successfully";

        return $responseObj;
    }

    // get all branches
    public function getAllBranchesArrayApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {
            $data = PetrosmartBranch::where('custb_id', "<>", "")
                ->whereNotNull('custb_id')
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartBranch::where('custb_id', "<>", "")
                ->whereNotNull('custb_id')
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartBranch::where('custb_id', "<>", "")
                ->whereNotNull('custb_id')
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Branches were pulled successfully";

        return $responseObj;
    }


    // Edit user data
    public function editAdminUserApi(Request $request)
    {

        // Get variables from session
        $session_email = Session::get('email');

        // Set form process status here 

        $requesterForm =  PetrosmartCustomers::where("app_user_id", $request->get('app_user_id'))->first();

        //set values into db
        $requesterForm->full_name =  $request->get('fullName');
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

        $requesterForm =  PetrosmartCustomers::where("app_user_id", $request->get('app_user_id'))->first();

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
    public function getAdminUsersDataApi(Request $request)
    {
        $model = PetrosmartCustomers::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cust_id', "<>", "")
                        ->whereNotNull('cust_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cust_id', "<>", "")
                        ->whereNotNull('cust_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('cust_id', "<>", "")
                        ->whereNotNull('cust_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
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

    // get all data in contacts 
    public function getContactUsersDataApi(Request $request)
    {
        $model = PetrosmartContact::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custc_id', "<>", "")
                        ->whereNotNull('custc_id')
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custc_id', "<>", "")
                        ->whereNotNull('custc_id')
                        ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('custc_id', "<>", "")
                        ->whereNotNull('custc_id')
                        ->where('created_by', Session::get('managerEmail'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // get all data in countries 
    public function getCountriesUsersDataApi(Request $request)
    {
        $model = PetrosmartCountries::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('ccountry_id', "<>", "")
                        ->whereNotNull('ccountry_id')

                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('ccountry_id', "<>", "")
                        ->whereNotNull('ccountry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('ccountry_id', "<>", "")
                        ->whereNotNull('ccountry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // get all data in wallets 
    public function getWalletUsersDataApi(Request $request)
    {
        $model = PetrosmartWallet::query();

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

    // get all data in industries 
    public function getIndustriesUsersDataApi(Request $request)
    {
        $model = PetrosmartIndustries::query();

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('industry_id', "<>", "")
                        ->whereNotNull('industry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "MANAGER") {
            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('industry_id', "<>", "")
                        ->whereNotNull('industry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            return DataTables::of($model)->addIndexColumn()
                ->filter(function ($query) use ($request) {

                    $query->where('industry_id', "<>", "")
                        ->whereNotNull('industry_id')
                        // ->where('created_by', Session::get('email'))
                        ->orderBy('created_at', 'desc');
                })->make(true);
        }
    }

    // get customer branches array
    public function getCustomerBranchesApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {
            $data = PetrosmartBranch::where(strtoupper('customer_selected'), strtoupper($request->get('customerId')))
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartBranch::where(strtoupper('customer_selected'), strtoupper($request->get('customerId')))
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartBranch::where(strtoupper('customer_selected'), strtoupper($request->get('customerId')))
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Customer Branches were pulled successfully";

        return $responseObj;
    }

    // get customer branches drivers array
    public function getCustomerBranchesDriversApi(Request $request)
    {
        $responseObj = [];

        $userRole = strtoupper(Session::get('userRole'));
        if ($userRole == "ADMIN") {
            $data = PetrosmartDrivers::where(strtoupper('branch_id'), strtoupper($request->get('branchId')))
                // ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "MANAGER") {
            $data = PetrosmartDrivers::where(strtoupper('branch_id'), strtoupper($request->get('branchId')))
                ->where('created_by', Session::get('email'))
                ->get();
        }

        if ($userRole == "USER") {
            $managerEmail = Session::get('managerEmail');

            $data = PetrosmartDrivers::where(strtoupper('branch_id'), strtoupper($request->get('branchId')))
                ->where('created_by', $managerEmail)
                ->get();
        }

        $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
        $responseObj['RESPONSE_DATA'] = $data;
        $responseObj['RESPONSE_MESSAGE'] = "Customer Branches drivers were pulled successfully";

        return $responseObj;
    }
}
