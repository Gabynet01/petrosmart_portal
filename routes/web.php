<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\RedirectIfNotLoggedIn;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin and common routes
Route::get('/', 'AdminController@index')->middleware(RedirectIfNotLoggedIn::class);
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/loginApi', 'AdminController@login');
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::get('/unauthorisedPage', 'AdminController@unauthorisedPage')->name('Unauthorised');
Route::get('/unsupportedPage', 'AdminController@unsupportedPage')->name('Unsupported');


//Handle everything companies here
Route::get('/companyList', 'CompanyController@index')->name('Companies')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getAdminUsersDataApi', 'CompanyController@getAdminUsersDataApi');
Route::post('/addPetrosmartCustomerApi', 'CompanyController@addPetrosmartCustomerApi');

//Handle everything company brances here
Route::get('/companyBranchList', 'CompanyBranchesController@index')->name('Company Branches')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getBranchUsersDataApi', 'CompanyBranchesController@getBranchUsersDataApi');
Route::post('/addPetrosmartBranchApi', 'CompanyBranchesController@addPetrosmartBranchApi');

//Handle everything company drivers here
Route::get('/companyDriversList', 'CompanyDriversController@index')->name('Company Drivers')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getDriverDataApi', 'CompanyDriversController@getDriverDataApi');
Route::post('/addPetrosmartDriverApi', 'CompanyDriversController@addPetrosmartDriverApi');
Route::any('/setRulesForDriversApi', 'CompanyDriversController@setRulesForDriversApi');

//Handle everything company vehicles here
Route::get('/companyVehiclesList', 'CompanyVehiclesController@index')->name('Company Vehicles')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getVehicleDataApi', 'CompanyVehiclesController@getVehicleDataApi');
Route::post('/addPetrosmartVehicleApi', 'CompanyVehiclesController@addPetrosmartVehicleApi');


//Handle everything company wallets here
Route::get('/companyWalletsList', 'CompanyWalletsController@index')->name('Company Wallets')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getWalletUsersDataApi', 'CompanyWalletsController@getWalletUsersDataApi');
Route::post('/addPetrosmartWalletApi', 'CompanyWalletsController@addPetrosmartWalletApi');

//Handle everything company vouchers here
Route::get('/companyVouchersList', 'CompanyVouchersController@index')->name('Company Vouchers')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getFuelVouchersDataApi', 'CompanyVouchersController@getFuelVouchersDataApi');
Route::post('/addPetrosmartFuelVouchersApi', 'CompanyVouchersController@addPetrosmartFuelVouchersApi');
Route::any('/getVoucherUsageTypeApi', 'CompanyVouchersController@getVoucherUsageTypeApi');
Route::post('/checkWalletBalanceApi', 'CompanyVouchersController@checkWalletBalanceApi');

//Handle everything driver vouchers here
Route::get('/driverVouchersList', 'DriverVouchersController@index')->name('Driver Vouchers')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getDriverFuelVouchersDataApi', 'DriverVouchersController@getDriverFuelVouchersDataApi');

//Handle everything company contacts here
Route::get('/companyContactsList', 'CompanyContactsController@index')->name('Company Contacts')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getContactUsersDataApi', 'CompanyContactsController@getContactUsersDataApi');
Route::post('/addPetrosmartContactApi', 'CompanyContactsController@addPetrosmartContactApi');

//Handle everything settings --- countries
Route::get('/countryList', 'CountryController@index')->name('Countries')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getCountriesUsersDataApi', 'CountryController@getCountriesUsersDataApi');
Route::post('/addPetrosmartCountryApi', 'CountryController@addPetrosmartCountryApi');

//Handle everything settings --- industries
Route::get('/industryList', 'IndustryController@index')->name('Industries')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getIndustriesUsersDataApi', 'IndustryController@getIndustriesUsersDataApi');
Route::post('/addPetrosmartIndustryApi', 'IndustryController@addPetrosmartIndustryApi');

//Handle everything All OMC
Route::get('/omcList', 'OmcController@index')->name('All Omc')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getOmcDataApi', 'OmcController@getOmcDataApi');
Route::post('/addPetrosmartOmcApi', 'OmcController@addPetrosmartOmcApi');

//Handle everything Stations
Route::get('/stationsList', 'StationsController@index')->name('Stations')->middleware(RedirectIfNotLoggedIn::class);
Route::post('/addPetrosmartFuelStationApi', 'StationsController@addPetrosmartFuelStationApi');
Route::any('/getFuelStationsDataApi', 'StationsController@getFuelStationsDataApi');

//Handle everything Clustered Stations
Route::get('/clusteredStationsList', 'ClusteredStationsController@index')->name('Clustered Stations')->middleware(RedirectIfNotLoggedIn::class);
Route::post('/addPetrosmartClusteredStationApi', 'ClusteredStationsController@addPetrosmartClusteredStationApi');
Route::any('/getClusteredStationsDataApi', 'ClusteredStationsController@getClusteredStationsDataApi');

//Handle everything Station Attendants
Route::get('/stationAttendantsList', 'StationAttendantsController@index')->name('Station Attendants')->middleware(RedirectIfNotLoggedIn::class);
Route::post('/addPetrosmartFuelAttendantsApi', 'StationAttendantsController@addPetrosmartFuelAttendantsApi');
Route::any('/getFuelAttendantsDataApi', 'StationAttendantsController@getFuelAttendantsDataApi');

//Handle everything Station Wallets
Route::get('/stationWalletsList', 'StationWalletsController@index')->name('Station Wallets')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getWalletFuelStationDataApi', 'StationWalletsController@getWalletFuelStationDataApi');
Route::post('/addFuelStationWalletApi', 'StationWalletsController@addFuelStationWalletApi');

//handle everything Station POS
Route::get('/stationPosList', 'StationPosController@index')->name('Station Pos')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/getFuelPosDataApi', 'StationPosController@getFuelPosDataApi');
Route::post('/addPetrosmartFuelPosApi', 'StationPosController@addPetrosmartFuelPosApi');






// Handle PETROSMART CUSTOMERS ROUTES
Route::get('/chartDashboard', 'ChartDashboardController@index')->name('Chart Dashboard')->middleware(RedirectIfNotLoggedIn::class);

// Route::get('/petrosmartCompanyList', 'PetrosmartCustomerController@index')->name('Petrosmart Customer')->middleware(RedirectIfNotLoggedIn::class);
// Route::post('/addPetrosmartCustomerApi', 'PetrosmartCustomerController@addPetrosmartCustomerApi');
// Route::post('/addPetrosmartIndustryApi', 'PetrosmartCustomerController@addPetrosmartIndustryApi');
// Route::post('/addPetrosmartCountryApi', 'PetrosmartCustomerController@addPetrosmartCountryApi');
Route::any('/getCustomerBranchesApi', 'PetrosmartCustomerController@getCustomerBranchesApi');
Route::any('/getCustomerBranchesDriversApi', 'PetrosmartCustomerController@getCustomerBranchesDriversApi');
Route::any('/getCustomersArrayApi', 'PetrosmartCustomerController@getCustomersArrayApi');
Route::any('/getCountriesArrayApi', 'PetrosmartCustomerController@getCountriesArrayApi');
Route::any('/getIndustriesArrayApi', 'PetrosmartCustomerController@getIndustriesArrayApi');
Route::any('/getAllBranchesArrayApi', 'PetrosmartCustomerController@getAllBranchesArrayApi');
// Route::post('/addPetrosmartBranchApi', 'PetrosmartCustomerController@addPetrosmartBranchApi');
// Route::post('/addPetrosmartContactApi', 'PetrosmartCustomerController@addPetrosmartContactApi');
// Route::post('/addPetrosmartWalletApi', 'PetrosmartCustomerController@addPetrosmartWalletApi');
// Route::any('/getAdminUsersDataApi', 'PetrosmartCustomerController@getAdminUsersDataApi');
// Route::any('/getBranchUsersDataApi', 'PetrosmartCustomerController@getBranchUsersDataApi');
// Route::any('/getContactUsersDataApi', 'PetrosmartCustomerController@getContactUsersDataApi');
// Route::any('/getCountriesUsersDataApi', 'PetrosmartCustomerController@getCountriesUsersDataApi');
// Route::any('/getWalletUsersDataApi', 'PetrosmartCustomerController@getWalletUsersDataApi');
// Route::any('/getIndustriesUsersDataApi', 'PetrosmartCustomerController@getIndustriesUsersDataApi');


// Handle PETROSMART FUEL STATION ROUTES
// Route::get('/petrosmartOmcList', 'PetrosmartFuelStationController@index')->name('PetrosmartOmc')->middleware(RedirectIfNotLoggedIn::class);
// Route::post('/addPetrosmartFuelStationApi', 'PetrosmartFuelStationController@addPetrosmartFuelStationApi');
// Route::any('/getFuelStationsDataApi', 'PetrosmartFuelStationController@getFuelStationsDataApi');
// Route::post('/addPetrosmartFuelAttendantsApi', 'PetrosmartFuelStationController@addPetrosmartFuelAttendantsApi');
// Route::post('/addPetrosmartClusteredStationApi', 'PetrosmartFuelStationController@addPetrosmartClusteredStationApi');
// Route::any('/getClusteredStationsDataApi', 'PetrosmartFuelStationController@getClusteredStationsDataApi');
// Route::any('/getFuelAttendantsDataApi', 'PetrosmartFuelStationController@getFuelAttendantsDataApi');
Route::any('/getFuelStationsArrayApi', 'PetrosmartFuelStationController@getFuelStationsArrayApi');
Route::any('/getClusteredArrayApi', 'PetrosmartFuelStationController@getClusteredArrayApi');
Route::any('/getOmcArrayApi', 'PetrosmartFuelStationController@getOmcArrayApi');
Route::any('/getPosArrayApi', 'PetrosmartFuelStationController@getPosArrayApi');
Route::any('/getCustomerVouchersApi', 'PetrosmartFuelStationController@getCustomerVouchersApi');
Route::any('/getDriverVehiclesApi', 'PetrosmartFuelStationController@getDriverVehiclesApi');
// Route::any('/getVoucherUsageTypeApi', 'PetrosmartFuelStationController@getVoucherUsageTypeApi');
// Route::any('/getFuelVouchersDataApi', 'PetrosmartFuelStationController@getFuelVouchersDataApi');
// Route::any('/getDriverFuelVouchersDataApi', 'PetrosmartFuelStationController@getDriverFuelVouchersDataApi');
// Route::post('/addPetrosmartFuelVouchersApi', 'PetrosmartFuelStationController@addPetrosmartFuelVouchersApi');
// Route::any('/getFuelPosDataApi', 'PetrosmartFuelStationController@getFuelPosDataApi');
// Route::post('/addPetrosmartFuelPosApi', 'PetrosmartFuelStationController@addPetrosmartFuelPosApi');
// Route::any('/getOmcDataApi', 'PetrosmartFuelStationController@getOmcDataApi');
// Route::post('/addPetrosmartOmcApi', 'PetrosmartFuelStationController@addPetrosmartOmcApi');
Route::any('/getVouchersArrayApi', 'PetrosmartFuelStationController@getVouchersArrayApi');
Route::any('/getPaymentDataApi', 'PetrosmartFuelStationController@getPaymentDataApi');
Route::post('/addPetrosmartPaymentApi', 'PetrosmartFuelStationController@addPetrosmartPaymentApi');
Route::any('/getPurchaseDataApi', 'PetrosmartFuelStationController@getPurchaseDataApi');
Route::post('/addPetrosmartPurchaseApi', 'PetrosmartFuelStationController@addPetrosmartPurchaseApi');
// Route::any('/getDriverDataApi', 'PetrosmartFuelStationController@getDriverDataApi');
// Route::any('/getVehicleDataApi', 'PetrosmartFuelStationController@getVehicleDataApi');
Route::any('/getDevicesArrayApi', 'PetrosmartFuelStationController@getDevicesArrayApi');
// Route::any('/setRulesForDriversApi', 'PetrosmartFuelStationController@setRulesForDriversApi');
Route::any('/getVehiclesArrayApi', 'PetrosmartFuelStationController@getVehiclesArrayApi');
Route::any('/getDriverArrayApi', 'PetrosmartFuelStationController@getDriverArrayApi');
// Route::post('/addPetrosmartDriverApi', 'PetrosmartFuelStationController@addPetrosmartDriverApi');
Route::post('/deleteDriverUserApi', 'PetrosmartFuelStationController@deleteDriverUserApi');
Route::post('/deleteGlobalApi', 'PetrosmartFuelStationController@deleteGlobalApi');
Route::post('/deactivateDriverVoucherApi', 'PetrosmartFuelStationController@deactivateDriverVoucherApi');
// Route::post('/addPetrosmartVehicleApi', 'PetrosmartFuelStationController@addPetrosmartVehicleApi');
// Route::any('/getWalletFuelStationDataApi', 'PetrosmartFuelStationController@getWalletFuelStationDataApi');
// Route::post('/addFuelStationWalletApi', 'PetrosmartFuelStationController@addFuelStationWalletApi');

// Notifications 
Route::get('/petrosmartNotifications', 'PetrosmartNotificationsController@index')->name('Petrosmart Notifications')->middleware(RedirectIfNotLoggedIn::class);
Route::post('/addPetrosmartNotificationApi', 'PetrosmartNotificationsController@addPetrosmartNotificationApi');
Route::any('/getNotificationsDataApi', 'PetrosmartNotificationsController@getNotificationsDataApi');
Route::any('/getNotificationArrayApi', 'PetrosmartNotificationsController@getNotificationArrayApi');
Route::post('/assignPetrosmartNotificationApi', 'PetrosmartNotificationsController@assignPetrosmartNotificationApi');
Route::any('/getNotificationAssignmentArrayApi', 'PetrosmartNotificationsController@getNotificationAssignmentArrayApi');

// OMC Users
// Manage Users and Reports 
Route::any('/applicationUsers', 'ManageUsersAndReportsController@manageApplicationUsers')->name('ManageAppUsers')->middleware(RedirectIfNotLoggedIn::class);
Route::post('/addAdminUserApi', 'ManageUsersAndReportsController@addAdminUserApi');
Route::any('/getOmcUsersDataApi', 'ManageUsersAndReportsController@getAdminUsersData');
Route::post('/editAdminUserApi', 'ManageUsersAndReportsController@editAdminUserApi');
Route::post('/deleteAdminUserApi', 'ManageUsersAndReportsController@deleteAdminUserApi');

// FLEET MANAGERS 
Route::any('/fleetManagerRequests', 'FleetManagerController@fleetManagerRequests')->name('FleetManagerRequests')->middleware(RedirectIfNotLoggedIn::class);
Route::any('/manageFleetManagers', 'FleetManagerController@manageApplicationUsers')->name('ManageFleetManagers')->middleware(RedirectIfNotLoggedIn::class);
Route::post('/addFleetManagerApi', 'FleetManagerController@addFleetManagerApi');
Route::any('/getFleetManagersDataApi', 'FleetManagerController@getFleetManagersData');
Route::any('/getFleetManagersRequestsDataApi', 'FleetManagerController@getFleetManagersRequestsDataApi');
Route::any('/getManagersArrayApi', 'FleetManagerController@getManagersArrayApi');
Route::post('/editFleetManagerApi', 'FleetManagerController@editFleetManagerApi');
Route::post('/deleteFleetManagerApi', 'FleetManagerController@deleteFleetManagerApi');
Route::post('/makeApiCallToApprove', 'FleetManagerController@makeApiCallToApprove');