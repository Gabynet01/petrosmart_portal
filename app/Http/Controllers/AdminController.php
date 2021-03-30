<?php

namespace App\Http\Controllers;

use App\AppUsersModel;
use App\Http\Requests\User\StoreUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\PetrosmartOmcUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        if (Session::has('userRole')) {
            $sessionRole = Session::get('userRole');

            if (strtoupper($sessionRole) == "ADMIN") {
                // return redirect()->route('Petrosmart Customer');
                return redirect()->route('Companies');
            }
            if (strtoupper($sessionRole) == "OMC") {
                // return redirect()->route('PetrosmartOmc');
                return redirect()->route('All Omc');
            }
            if (strtoupper($sessionRole) == "USER" || strtoupper($sessionRole) == "MANAGER") {
                // return redirect()->route('Petrosmart Customer');
                return redirect()->route('Companies');
            }
        }
    }

    // unauthorised error 404 page
    public function unauthorisedPage()
    {
        return view('error.404');
    }

    // unsupported page
    public function unsupportedPage()
    {
        return view('error.unsupported');
    }

    public function indexPage(Request $request)
    {
        return view("pages.admins.index");
    }

    public function unsupported()
    {
        return view('errors.unsuported');
    }

    public function dashboard()
    {
        return redirect()->action('AdminController@db_login', ['userEmail' => Session::get('email')]);
    }

    //Logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    // Login
    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $loginResp =  $this->db_login($username, $password);

        $responseObj = [];
        $responseObj['RESPONSE_CODE'] = $loginResp['RESPONSE_CODE'];
        $responseObj['RESPONSE_MESSAGE'] = $loginResp['RESPONSE_MESSAGE'];


        if ($loginResp['RESPONSE_CODE'] == Response::HTTP_OK) {
         
            $responseObj['RESPONSE_EXTRA']['EMAIL'] = Session::get('email');
            $responseObj['RESPONSE_EXTRA']['FULLNAME'] = Session::get('full_name');
        }

        return response()->json($responseObj)->setStatusCode($loginResp['RESPONSE_CODE']);
    }


    // System Login Check
    private function db_login($username, $password)
    {

        if (PetrosmartOmcUsers::where("email", $username)->exists()) {

            $user = PetrosmartOmcUsers::where("email", $username)->where("password", $password)->get();

            if (!$user->isEmpty()) {
                $user = PetrosmartOmcUsers::where("email", $username)->where("password", $password)->first();
                // Session::put('email', $user->user_id);
                Session::put('userRole', "OMC");
                Session::put('userId', strtolower($user->id));
                Session::put('username', strtolower($user->id));
                Session::put('email', strtolower($user->id));
                Session::put('full_name', strtolower($user->name));

                $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
                $responseObj['RESPONSE_MESSAGE'] = "Login Successful";
                $responseObj['RESPONSE_DATA'] = $user;
                // return redirect()->route('PetrosmartOmc')->with($responseObj);
                return $responseObj;
            } else {
                session()->flush();
                $responseObj['RESPONSE_CODE'] = Response::HTTP_UNAUTHORIZED;
                $responseObj['RESPONSE_MESSAGE'] = "Invalid Username Or Password";
                // return redirect()->route('login')->with($responseObj);
                return $responseObj;
                // return Redirect::route('login')->withInput()->with('message', trans('front.login_failed'));
            }
        }

        //lets check who is logged in since it is not an OMC user
        if (AppUsersModel::where("email", $username)->exists()) {

            // $user = AppUsersModel::where("email", $username)->where("password", $password)->get();
            $user = AppUsersModel::where("email", $username)->first();

            //lets check if user is active
            if ($user->active != 1) {
                session()->flush();
                $responseObj['RESPONSE_CODE'] = Response::HTTP_FORBIDDEN;
                $responseObj['RESPONSE_MESSAGE'] = "User is not active, kindly see admin";

                return $responseObj;
            }

            //since user is active lets check the password entered if it matches
            //remember that password in the db is hashed using BCRYPT
            //password_verify is an inbuilt PHP function to check BCRYPT passwords

            if (password_verify($password, $user->password)) {
                //since password is valid lets check which user is logged in and set necessary infos
                //group_id --> 1 (Admin), group_id --> 2 (User), group_id --> 3 (Manager)

                if ($user->group_id == 1) {
                    Session::put('userRole', "admin");
                }

                if ($user->group_id == 2) {
                    Session::put('userRole', "user");
                }

                if ($user->group_id == 3) {
                    Session::put('userRole', "manager");
                }

                //lets check if a manager ID exists and fetch the email of the manager and save it in session
                if ($user->manager_id !== null) {
                    $managerInfo = AppUsersModel::where("id", $user->manager_id)->first();
                    //set manager email into session
                    Session::put('managerEmail', $user->manager_id);
                }

                //save these defaults
                Session::put('username', strtolower($user->id));
                Session::put('userId', strtolower($user->id));
                Session::put('email', strtolower($user->id));
             
                $responseObj['RESPONSE_CODE'] = Response::HTTP_OK;
                $responseObj['RESPONSE_MESSAGE'] = "Login Successful";
                $responseObj['RESPONSE_DATA'] = $user;

                return $responseObj;
            } else {
                $responseObj['RESPONSE_CODE'] = Response::HTTP_UNAUTHORIZED;
                $responseObj['RESPONSE_MESSAGE'] = "Invalid Username Or Password";
                return $responseObj;
            }
        } else {
            $responseObj['RESPONSE_CODE'] = Response::HTTP_UNAUTHORIZED;
            $responseObj['RESPONSE_MESSAGE'] = "Sorry, You do not have access to this application";
            return $responseObj;
        }
    }
}
