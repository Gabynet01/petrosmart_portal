@extends('petrosmart_pages.masterlayout')

@section('title', 'Petrosmart | Manage Stations')

@section('content')

<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
    <div class="w3-card-2 w3-white panel default-sidebar">
        <!-- Begin Side Navbar -->
        <nav class="side-navbar box-scroll sidebar-scroll">
            <!-- Begin Main Navigation -->
            <ul class="list-unstyled">

                @if(strtoupper(session('userRole')) !== "OMC")
                <li>
                    <a href="/companyList">
                        <i class="ti ti-layers"></i>
                        <span class="text">Companies</span>
                    </a>
                </li>
                <li>
                    <a href="/companyBranchList">
                        <i class="ti ti-layout"></i>
                        <span class="text">Branches</span>
                    </a>
                </li>
                <li>
                    <a href="/companyDriversList">
                        <i class="ti ti-id-badge"></i>
                        <span class="text">Drivers</span>
                    </a>
                </li>
                <li>
                    <a href="/companyVehiclesList">
                        <i class="ti ti-car"></i>
                        <span class="text">Vehicles</span>
                    </a>
                </li>
                <li>
                    <a href="/companyWalletsList">
                        <i class="ti ti-wallet"></i>
                        <span class="text">Wallets</span>
                    </a>
                </li>
                <li><a href="#dropdown-voucher-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-medall"></i>
                        <span>Vouchers</span>
                    </a>
                    <ul id="dropdown-voucher-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/companyVouchersList">Company</a></li>
                        <li><a href="/driverVouchersList">Drivers</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/companyContactsList">
                        <i class="ti ti-mobile"></i>
                        <span class="text">Contacts</span>
                    </a>
                </li>
                <li><a href="#dropdown-settings-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-settings"></i>
                        <span>Settings</span>
                    </a>
                    <ul id="dropdown-settings-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/countryList">Countries</a></li>
                        <li><a href="/industryList">Industries</a></li>
                    </ul>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "OMC")

                <li><a href="#dropdown-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-world"></i>
                        <span>OMC</span>
                    </a>
                    <ul id="dropdown-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/omcList">All OMC</a></li>
                        <li><a href="/applicationUsers">Manage Users</a></li>
                    </ul>
                </li>
                <li><a href="#dropdown-fuel-stations" aria-expanded="true" data-toggle="collapse" class="active"><i class="ti-bolt"></i>
                        <span>Fuel Stations</span>
                    </a>
                    <ul id="dropdown-fuel-stations" class="list-unstyled pt-0">
                        <li><a href="/stationsList" class="sub_active">Stations</a></li>
                        <li><a href="/clusteredStationsList">Clustered Stations</a></li>
                        <li><a href="/stationAttendantsList">Attendants</a></li>
                        <li><a href="/stationWalletsList">Wallets</a></li>
                        <li><a href="/posMachinesList">POS Machines</a></li>
                    </ul>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                <li><a href="#dropdown-fleet-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-id-badge"></i>
                        <span>Fleet Manager</span>
                    </a>
                    <ul id="dropdown-fleet-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/fleetManagerRequests">All Requests</a></li>
                        <li><a href="/manageFleetManagers">Manage Users</a></li>
                    </ul>
                </li>
                @endif


                @if(strtoupper(session('userRole')) !== "OMC")
                <li>
                    <a href="/petrosmartNotifications">

                        <i class="ti ti-bell"></i>
                        <span class="text">Notifications</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/chartDashboard" role="button">
                        <i class="ti ti-pie-chart"></i>
                        <span class="text">CHART-DASHBOARD</span>
                    </a>
                </li>


            </ul>


        </nav>
        <!-- End Side Navbar -->
    </div>
    <!-- End Left Sidebar -->
    <div class="content-inner">
        <div class="container-fluid">
            <div class="give-space"></div>

            <!-- Export -->
            <div class="row">
                <!-- Begin Row -->

                <div class="col-12">
                    <div class="w3-card-2 w3-white panel widget has-shadow">
                        <div class="widget-header bordered no-actions">
                            <div class="row">
                                <div class="col-10">
                                    <h4>All Fuel Stations</h4>
                                </div>

                                <div class="col-2">
                                    <h4><a href="#" data-toggle="modal" data-target="#addFuelStationModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Fuel Station</a></h4>
                                </div>
                            </div>

                        </div>

                        <div class="widget-body sliding-tabs">

                            <div class="table-responsive">
                                <table id="appFuelStationsDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                            </th>
                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Name: activate to sort column ascending">Name
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Address: activate to sort column ascending">Address
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="gps: activate to sort column ascending">GPS
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="gpsradius: activate to sort column ascending">GPS Radius
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="POS: activate to sort column ascending">POS
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="OMC: activate to sort column ascending">OMC
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Industry: activate to sort column ascending">Country
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Date: activate to sort column ascending">Created Date
                                            </th>
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <!-- End Row -->

        </div>
        <!-- End Container -->
        <!-- Begin Page Footer-->
        <footer class="main-footer fixed-footer">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-6 col-sm-12 d-flex align-items-center justify-content-xl-start justify-content-lg-start justify-content-md-start justify-content-center">
                    <p class="text-gradient-02"><b>&copy; 2019 - <?php echo date("Y"); ?> , Petrosmart </b> | All Rights Reserved</p>

                </div>
                <div class="col-xl-6 col-lg-6 col-6 col-sm-12 d-flex align-items-center justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">

                </div>
            </div>
        </footer>
        <!-- End Page Footer -->
        <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
        <!-- Offcanvas Sidebar -->

        <!-- End Offcanvas Sidebar -->
    </div>
    <!-- End Content -->

    <div id="addFuelStationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Fuel Station</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addName" placeholder="Fuel Station Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addGps" placeholder="Latitude, Longitude">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS Radius</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addGpsRadius" placeholder="Enter GPS radius">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <label class="form-control-label"></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="addEmailAddress" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-6">
                                <label class="form-control-label">Select POS</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_station_pos_add" multiple data-live-search="true" id="addStationPos" name="addStationPos">
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Select OMC</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_omc" data-live-search="true" id="addStationOMC" name="addStationOMC">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_country" data-live-search="true" id="addCountry" name="addCountry">
                                    </select>
                                </div>
                            </div>



                        </div>

                    </form>

                    <!--Loader and notification messages-->
                    <div class="modal_loader" style="display: none;">
                        <div align="center" style="margin-bottom:15px;" class="">
                            <div class="-spinner-ring -error-"></div>
                            <h5><span class="modalAlertPlaceHolder"></span></h5>
                        </div>
                    </div>

                    <div align="center">
                        <h5><span class="modalAlertPlaceHolder"></span></h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addFuelStationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--edit station modal-->
    <div id="editFuelStationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayStationName"></span></b> Station</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editName" placeholder="Fuel Station Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <label class="form-control-label">Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editGps" placeholder="Latitude, Longitude">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">GPS Radius</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editGpsRadius" placeholder="Enter GPS radius">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <label class="form-control-label"></label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="addEmailAddress" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-6">
                                <label class="form-control-label">Select POS</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_station_pos_edit" multiple data-live-search="true" id="editStationPos" name="editStationPos">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select OMC</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editFuelStationOmc" name="editFuelStationOmc">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editCountry" name="editCountry">
                                    </select>
                                </div>
                            </div>



                        </div>

                    </form>

                    <!--Loader and notification messages-->
                    <div class="modal_loader" style="display: none;">
                        <div align="center" style="margin-bottom:15px;" class="">
                            <div class="-spinner-ring -error-"></div>
                            <h5><span class="modalAlertPlaceHolder"></span></h5>
                        </div>
                    </div>

                    <div align="center">
                        <h5><span class="modalAlertPlaceHolder"></span></h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editFuelStationBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/custom/fuel_stations/stations.js')}}"></script>
@endpush