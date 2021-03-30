@extends('petrosmart_pages.masterlayout')

@section('title', 'Petrosmart | Manage Customers')

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
                    <a href="/petrosmartCompanyList" class="active">
                        <i class="ti ti-user"></i>
                        <p class="text">Companies</p>
                    </a>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "OMC")
                <li><a href="#dropdown-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-spray"></i>
                        <p>OMC</p>
                    </a>
                    <ul id="dropdown-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/petrosmartOmcList">All OMC</a></li>
                        <li><a href="/applicationUsers">Manage Users</a></li>
                    </ul>
                </li>
                @endif

                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "FLEETMANAGER")
                <li><a href="#dropdown-fleet-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-id-badge"></i>
                        <p>Fleet Manager</p>
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
                        <p class="text">Notifications</p>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/chartDashboard" role="button">
                        <i class="ti ti-pie-chart"></i>
                        <p class="text">CHART-DASHBOARD</p>
                    </a>
                </li>


            </ul>


        </nav>
        <!-- End Side Navbar -->
    </div>
    <!-- End Left Sidebar -->
    <div class="content-inner">
        <div class="container-fluid">

            <br>
            <!-- Dashboards Cards-->
            <div class="row">

                <!-- ALL -->
                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER" || strtoupper(session('userRole')) == "USER")
                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Companies</div>
                                    <div class="number">{{ $customers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Branches</div>
                                    <div class="number">{{ $branches }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Drivers</div>
                                    <div class="number">{{ $drivers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Vehicles</div>
                                    <div class="number">{{ $vehicles }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Wallets</div>
                                    <div class="number">{{ $wallets }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Vouchers</div>
                                    <div class="number">{{ $vouchers }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif


                <!-- ADMIN ONLY -->

                @if(strtoupper(session('userRole')) == "ADMIN")
                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Contacts</div>
                                    <div class="number">{{ $contacts }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Countries</div>
                                    <div class="number">{{ $countries }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Payments</div>
                                    <div class="number">{{ $payments }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="media">

                                <div class="media-body align-self-center" align="center">
                                    <div class="title">Industries</div>
                                    <div class="number">{{ $industries }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <br>

            <!-- Export -->
            <div class="row" id="allTableData">
                <div class="col-12">
                    <div class="w3-card-2 w3-white panel widget has-shadow">

                        <div class="widget-body sliding-tabs">
                            <ul class="nav nav-tabs" id="example-one" role="tablist">
                                @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER" || strtoupper(session('userRole')) == "USER")
                                <li class="nav-item">
                                    <a class="nav-link active" id="base-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Company</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2a" data-toggle="tab" href="#tab-2a" role="tab" aria-controls="tab-2a" aria-selected="false">Branches</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2j" data-toggle="tab" href="#tab-2j" role="tab" aria-controls="tab-2j" aria-selected="false">Drivers</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2k" data-toggle="tab" href="#tab-2k" role="tab" aria-controls="tab-2k" aria-selected="false">Vehicles</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2d" data-toggle="tab" href="#tab-2d" role="tab" aria-controls="tab-2d" aria-selected="false">Wallets</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2g" data-toggle="tab" href="#tab-2g" role="tab" aria-controls="tab-2g" aria-selected="false">Company Vouchers</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2Q" data-toggle="tab" href="#tab-2Q" role="tab" aria-controls="tab-2Q" aria-selected="false">Driver Vouchers</a>
                                </li>
                                @endif

                                <!-- ADMIN ONLY -->

                                @if(strtoupper(session('userRole')) == "ADMIN")
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2b" data-toggle="tab" href="#tab-2b" role="tab" aria-controls="tab-2b" aria-selected="false">Contacts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2c" data-toggle="tab" href="#tab-2c" role="tab" aria-controls="tab-2c" aria-selected="false">Countries</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2h" data-toggle="tab" href="#tab-2h" role="tab" aria-controls="tab-2h" aria-selected="false">Payments</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="base-tab-2e" data-toggle="tab" href="#tab-2e" role="tab" aria-controls="tab-2e" aria-selected="false">Industries</a>
                                </li>

                                @endif

                            </ul>
                            <div class="tab-content pt-3">
                                <!-- Companies -->
                                <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="base-tab-1">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Companies</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addUserModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Company</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="appCustomersDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">GPS
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Country
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Industry
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
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

                                <!-- Branches-->
                                <div class="tab-pane fade" id="tab-2a" role="tabpanel" aria-labelledby="base-tab-2a">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Branches</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addBranchModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Branch</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="branchesFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">GPS
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Contact 1
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Contact 2
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Country
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- Contacts -->
                                <div class="tab-pane fade" id="tab-2b" role="tabpanel" aria-labelledby="base-tab-2b">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Contacts</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addContactModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Contact</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="contactsFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Full Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Email
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Telephone
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Mobile
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- COUNTRIES -->
                                <div class="tab-pane fade" id="tab-2c" role="tabpanel" aria-labelledby="base-tab-2c">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Countries</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addCountryModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Country</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="countriesFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <!-- <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Customer
                                                                    </th> -->

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Vouchers -->
                                <div class="tab-pane fade" id="tab-2g" role="tabpanel" aria-labelledby="base-tab-2g">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Vouchers</h4>
                                                        </div>

                                                        @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")

                                                        <div class="col-2">
                                                            <h4><a href="#" data-toggle="modal" data-target="#addVoucherModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Voucher</a></h4>
                                                        </div>
                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="voucherFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Unit Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Total Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Drivers
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Expiry Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Vouchers -->
                                <div class="tab-pane fade" id="tab-2Q" role="tabpanel" aria-labelledby="base-tab-2Q">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Driver Vouchers</h4>
                                                        </div>
                                                       
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="driverVoucherFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Driver Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Balance
                                                                    </th>     

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Status
                                                                    </th>                                                                
                                                                  
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Expiry Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Payments-->
                                <div class="tab-pane fade" id="tab-2h" role="tabpanel" aria-labelledby="base-tab-2h">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Payments</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addPaymentModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Payment</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="paymentsFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Station
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Payment Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Code
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Amount
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Payment Date
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- wallets -->
                                <div class="tab-pane fade" id="tab-2d" role="tabpanel" aria-labelledby="base-tab-2d">

                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Wallets</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addWalletModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Wallet</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">

                                                        <table id="walletsFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Telco
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Wallet Number
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Authorization Key
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Merchant Token
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>


                                </div>


                                <!-- Industries -->
                                <div class="tab-pane fade" id="tab-2e" role="tabpanel" aria-labelledby="base-tab-2e">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Industries</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addIndustryModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Industry</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="industriesFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>
                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Drivers-->
                                <div class="tab-pane fade" id="tab-2j" role="tabpanel" aria-labelledby="base-tab-2j">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Drivers</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addDriversModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Driver</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="driversFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Date of Birth
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">E-mail Address
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Phone
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Device
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Vehicles
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Vehicles-->
                                <div class="tab-pane fade" id="tab-2k" role="tabpanel" aria-labelledby="base-tab-2k">
                                    <div class="row">
                                        <!-- Begin Row -->

                                        <div class="col-12">
                                            <div class="w3-card-2 w3-white panel widget has-shadow">
                                                <div class="widget-header bordered no-actions">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <h4>All Vehicles</h4>
                                                        </div>

                                                        <div class="col-2">
                                                            @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                            <h4><a href="#" data-toggle="modal" data-target="#addVehiclesModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add Vehicle</a></h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="widget-body sliding-tabs">

                                                    <div class="table-responsive">
                                                        <table id="vehiclesFormDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                                            <thead>
                                                                <tr role="row">
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Company
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Name
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Drivers
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Make
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Model
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Vehicle Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Plate No.
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Fuel Type
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Registration Date
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Branch
                                                                    </th>

                                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                                    </th>

                                                                    @if(strtoupper(session('userRole')) == "ADMIN" || strtoupper(session('userRole')) == "MANAGER")
                                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending">Actions
                                                                    </th>
                                                                    @endif

                                                                    @if(strtoupper(session('userRole')) == "USER")
                                                                    <th>
                                                                    </th>
                                                                    @endif
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

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

    <!--View add user modal-->
    <div id="addUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Company</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Full Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addFullname" placeholder="Full Name">
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

                            <div class="col-12">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addGps" placeholder="Enter GPS info">
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
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_country" data-live-search="true" id="addCountry" name="addCountry">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Industry</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_industries_picker" data-live-search="true" id="addIndustry" name="addIndustry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addUserBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit user modal-->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayCustomerName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Full Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editFullname" placeholder="Full Name">
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

                            <div class="col-12">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editGps" placeholder="Enter GPS info">
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
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editCountry" name="editCountry">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Industry</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editIndustry" name="editIndustry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editUserBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View add contact modal-->
    <div id="addContactModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Contact</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addContactForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control customerContactSelectpicker" data-live-search="true" id="addCustomerContact" name="addCustomerContact">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Email</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addEmailContact" placeholder="Contact Email">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Telephone</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addTelephoneContact" placeholder="Enter Telephone Contact">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Mobile</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addMobileContact" placeholder="Enter Mobile Contact">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addContactBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit contact modal-->
    <div id="editContactModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayContactName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addContactForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editCustomerContact" name="editCustomerContact">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Email</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editEmailContact" placeholder="Contact Email">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Telephone</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editTelephoneContact" placeholder="Enter Telephone Contact">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Mobile</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editMobileContact" placeholder="Enter Mobile Contact">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editContactBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View add branches modal-->
    <div id="addBranchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Branch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addBranchForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_branch_company" data-live-search="true" id="addBranchCompany" name="addBranchCompany">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Branch Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-home"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addBranchName" placeholder="Branch Name">
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
                                        <input type="text" class="form-control" id="addBranchAddress" placeholder="Enter Branch Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addBranchGps" placeholder="Enter GPS info">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Contact 1</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addBranchContact1" placeholder="Enter contact 1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Contact 2</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addBranchContact2" placeholder="Enter contact 2">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_picker_branch_country" data-live-search="true" id="addBranchCountry" name="addBranchCountry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addBranchBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit branches modal-->
    <div id="editBranchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayBranchName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addBranchForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editBranchCompany" name="editBranchCompany">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Branch Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-home"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editBranchName" placeholder="Branch Name">
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
                                        <input type="text" class="form-control" id="editBranchAddress" placeholder="Enter Branch Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">GPS</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-map-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editBranchGps" placeholder="Enter GPS info">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Contact 1</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editBranchContact1" placeholder="Enter contact 1">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Contact 2</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editBranchContact2" placeholder="Enter contact 2">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Country</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editBranchCountry" name="editBranchCountry">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editBranchBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View add industry modal-->
    <div id="addIndustryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Industry</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addIndustryForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Industry Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-home"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addIndustryName" placeholder="Industry Name">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addIndustryBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit industry modal-->
    <div id="editIndustryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayIndustryName"></span></b> Industry</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addIndustryForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Industry Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-home"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editIndustryName" placeholder="Industry Name">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editIndustryBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View add country modal-->
    <div id="addCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Country</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addCountryForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Country Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-world"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addCountryName" placeholder="Country Name">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addCountryBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit country modal-->
    <div id="editCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayCountryName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addCountryForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Country Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-world"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editCountryName" placeholder="Country Name">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editCountryBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View add wallet modal-->
    <div id="addWalletModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Wallet</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addWalletForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_wallet_company_picker" onchange="getCompanyBranches(this)" data-live-search="true" id="addCompanyWallet" name="addCompanyWallet">
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-control-label">Select Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_wallet_branch_picker" data-live-search="true" id="addWalletBranchSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Network</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addTelco" name="addTelco">
                                        <option value="">Select Telco</option>
                                        <option value="mtn">MTN</option>
                                        <option value="vodafone">Vodafone</option>
                                        <option value="airtelTigo">Airtel-Tigo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Wallet Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="addWalletNum" placeholder="Enter wallet number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Authorization Key</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-key"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addAuthKey" placeholder="Enter Authorization Key">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Merchant Token</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-key"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addMerchantToken" placeholder="Enter Merchant Token">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addWalletBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!--View edit wallet modal-->
    <div id="editWalletModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayWalletName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addWalletForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" onchange="getCompanyBranches(this)" data-live-search="true" id="editCompanyWallet" name="editCompanyWallet">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editWalletBranchSelect" name="editWalletBranchSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Network</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editTelco" name="editTelco">
                                        <option value="">Select Telco</option>
                                        <option value="mtn">MTN</option>
                                        <option value="vodafone">Vodafone</option>
                                        <option value="airtelTigo">Airtel-Tigo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Wallet Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="number" class="form-control" id="editWalletNum" placeholder="Enter wallet number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Authorization Key</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-key"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editAuthKey" placeholder="Enter Authorization Key">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Merchant Token</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-key"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editMerchantToken" placeholder="Enter Merchant Token">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editWalletBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add fuel vouchers -->
    <div id="addVoucherModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_voucher_customer_contact" onchange="getCompanyBranches(this)" data-live-search="true" id="addCustomerVoucherContact" name="addCustomerVoucherContact">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVoucherCompanyBranchSelect" name="addVoucherCompanyBranchSelect" onchange="getCompanyBranchesDrivers(this)">
                                        <!-- <option value="allBranch">All Branch</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Drivers</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_drivers_per_branch_picker" multiple data-live-search="true" id="addVoucherCompanyDriverBranchSelect" name="addVoucherCompanyDriverBranchSelect">
                                    </select>
                                </div>
                            </div>



                            <div class="col-6">
                                <label class="form-control-label">Select Voucher Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVoucherType" name="addVoucherType">
                                        <option value="">Select type</option>
                                        <option value="single_use">Single Use</option>
                                        <option value="multiple_use">Multiple Use</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Unit Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            GHS
                                        </span> -->
                                        <input type="number" class="form-control" id="addVoucherAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Select expiry date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="voucherExpiryDate" placeholder="Select when the voucher will expire">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addVoucherBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit fuel vouchers -->
    <div id="editVoucherModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <b><span id="displayVoucherName"></span></b> Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editCustomerVoucherContact" name="editCustomerVoucherContact">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Voucher Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editVoucherType" name="editVoucherType">
                                        <option value="">Select type</option>
                                        <option value="single_use">Single Use</option>
                                        <option value="multiple_use">Multiple Use</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            GHS
                                        </span> -->
                                        <input type="number" class="form-control" id="editVoucherAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Select expiry date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="editVoucherExpiryDate" placeholder="Select when the voucher will expire">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editVoucherBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- view voucher info -->
    <div id="viewVoucherInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="displayVoucherInfoName"></span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <div class="w3-card-2 w3-white widget widget-12 has-shadow">
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>Company:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayCompanyVname"></span></label></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Branch:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayBranchVname"></span></label></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Voucher Type:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayTypeVname"></span></label></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Total Amount:</p>
                                </div>
                                <div class="col-md-8">
                                    <p><label><span id="displayTotalAmountVname"></span></label></p>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="voucherInfoDisplayTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Driver Name
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Voucher Code
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Unit Amount
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Created Date
                                                    </th>

                                                    <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1">Expiry Date
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody id="populateVoucherInfoBody"></tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- add Payments -->
    <div id="addPaymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control paymentCustomerSelectpicker" onchange="getCustomerVouchers(this)" data-live-search="true" id="addPaymentCustomer" name="addPaymentCustomer">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control paymentDriverSelectpicker" data-live-search="true" id="addPaymentDriver" name="addPaymentDriver">
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">Select Fuel Station</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_fuel_stations_picker_payment" data-live-search="true" id="addFuelStationsPayment" name="addFuelStationsPayment">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Payment Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addPaymentType" name="addPaymentType" onchange="getPaymentType(this)">
                                        <option value="">Select type</option>
                                        <option value="Voucher">Voucher</option>
                                        <option value="Company">Company</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6" id="voucherDiv">
                                <label class="form-control-label">Select Voucher</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_voucher_picker" onchange="getVoucherUsageType(this)" data-live-search="true" id="addCustomerVoucherCode" name="addCustomerVoucherCode">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6" id="companyAmountDiv">
                                <label class="form-control-label">Enter Amount</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <!-- <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span> -->
                                        <input type="text" class="form-control" id="addCompanyAmount" placeholder="Enter Amount">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12" id="multipleAmountDiv">
                                <div class="row">

                                    <div class="col-6">
                                        <div style="padding-top: 30px;"></div>
                                        <input id="addVoucherTypeCustomer" hidden />
                                        <label class="form-control-label"><span id="voucherTypeIdentified"></span> Voucher Total (<b><span id="totalVoucherAmount"></span></b>)</label>
                                    </div>
                                    <div class="col-6" id="multipleOnlyDiv">
                                        <label class="form-control-label">Enter Amount</label>
                                        <br>
                                        <label class="form-control-label">Voucher Balance (<b><span id="totalVoucherBalance"></span></b>)</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <!-- <span class="input-group-addon">
                                            <i class="ti-location-pin"></i>
                                        </span> -->
                                                <input type="text" class="form-control" id="addMultipleUseAmount" placeholder="Enter Amount">
                                            </div>
                                        </div>
                                    </div>

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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addPaymentBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add Drivers -->
    <div id="addDriversModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="driverDisplayName"><span>'s Profile</h4>
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
                                        <input type="text" class="form-control" id="addDriverName" placeholder="Enter Name">
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
                                        <input type="text" class="form-control" id="addDriverAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Phone</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-mobile"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addDriverPhone" placeholder="Enter Phone">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Email</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addDriverEmail" placeholder="Enter Email">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Device</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="addDeviceSelect" name="addDeviceSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Vehicles</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_driver_vehicles_picker" multiple data-live-search="true" id="addDriverVehiclesSelect" name="addDriverVehiclesSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_company_driver_picker" onchange="getCompanyBranches(this)" data-live-search="true" id="addDriverCompanySelect" name="addDriverCompanySelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addDriverCompanyBranchSelect" name="addDriverCompanyBranchSelect">
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">

                                <label class="form-control-label d-flex ">Date of Birth</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="addDobDriver" placeholder="Select Date of Birth">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addNewDriverBtn">Add driver</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addDriverBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Drivers Rules Modal -->
    <div id="DriverRulesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="driverDisplayRulesName"><span>'s Limits</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per transaction</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="transactionVolumeLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyVolumeLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyVolumeLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyTransactionLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per Day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyAmountLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyTransactionLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyAmountLimit">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3"><label class="form-control-label">Purchase Week Days</label></div>
                                    <div class="col-3">


                                        <div class="mb-3">
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-1" value="Sunday">
                                                <label for="check-1">Sunday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-2" value="Monday">
                                                <label for="check-2">Monday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-3" value="Tuesday">
                                                <label for="check-3">Tuesday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-4" value="Wednessday">
                                                <label for="check-4">Wednessday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-5" value="Thursday">
                                                <label for="check-5">Thursday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-6" value="Friday">
                                                <label for="check-6">Friday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDays" id="check-7" value="Saturday">
                                                <label for="check-7">Saturday</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Daily Purchase Period</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>

                                                <input type="text" class="form-control" id="addTimeOfDayToCard" placeholder="Select time card can be used">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkFillingStation">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Filling Stations</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control select_picker_rules_omc" multiple data-live-search="true" id="allowedOmcRules">
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkProducts">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Products</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="allowedProductRules">
                                                <option value="">Select product</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="Petrol">Petrol</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkIncorrectPin">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Incorrect PIN entries maximum</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="incorrectPinEntry">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row" id="checkPurchase">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Purchase lock-out Period</label>

                                    </div>

                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="cardLockPeriodType">
                                                <option value="">Period type</option>
                                                <option value="Minutes">Minutes</option>
                                                <option value="Hours">Hours</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="cardLockPeriodValue">
                                            </div>
                                        </div>
                                    </div>

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

                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addDriverRulesBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- show Drivers Rules Modal -->
    <div id="showDriverRulesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="showDriverDisplayRulesName"><span>'s Limits</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editDriverRulesForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per transaction</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="transactionVolumeLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyVolumeLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Volume per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyVolumeLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyTransactionLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per Day</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="dailyAmountLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Transactions per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyTransactionLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Amount per week</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="weeklyAmountLimitShow">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3"><label class="form-control-label">Purchase Week Days</label></div>
                                    <div class="col-3">


                                        <div class="mb-3">
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-1" value="Sunday">
                                                <label for="checkShow-1">Sunday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-2" value="Monday">
                                                <label for="checkShow-2">Monday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-3" value="Tuesday">
                                                <label for="checkShow-3">Tuesday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-4" value="Wednessday">
                                                <label for="checkShow-4">Wednessday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-5" value="Thursday">
                                                <label for="checkShow-5">Thursday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-6" value="Friday">
                                                <label for="checkShow-6">Friday</label>
                                            </div>
                                            <div class="styled-checkbox">
                                                <input type="checkbox" name="checkboxWeekDaysShow" id="checkShow-7" value="Saturday">
                                                <label for="checkShow-7">Saturday</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Daily Purchase Period</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="la la-calendar"></i>
                                                </span>

                                                <input type="text" class="form-control" id="addTimeOfDayToCardShow" placeholder="Select time card can be used">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Filling Stations</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control select_picker_rules_omc_update" multiple data-live-search="true" id="allowedOmcRulesShow">
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label d-flex ">Allowed Products</label>
                                    </div>
                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="allowedProductRulesShow">
                                                <option value="">Select product</option>
                                                <option value="Diesel">Diesel</option>
                                                <option value="Petrol">Petrol</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Incorrect PIN entries maximum</label>

                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="incorrectPinEntryShow">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3"></div>

                                    <div class="col-3">
                                        <label class="form-control-label">Purchase lock-out Period</label>

                                    </div>

                                    <div class="col-3">

                                        <div class="form-group">
                                            <select class="custom-select-roletype form-control" id="cardLockPeriodTypeShow">
                                                <option value="">Period type</option>
                                                <option value="Minutes">Minutes</option>
                                                <option value="Hours">Hours</option>
                                            </select>
                                        </div>

                                    </div>


                                    <div class="col-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="ti-spray"></i>
                                                </span>
                                                <input type="number" class="form-control" id="cardLockPeriodValueShow">
                                            </div>
                                        </div>
                                    </div>

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

                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editDriverRulesBtn">Update Rules</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add Vehicles -->
    <div id="addVehiclesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-car"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehicleName" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Make</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehicleMake" placeholder="Enter Make">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Model</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehicleModel" placeholder="Enter Model">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Number Plate</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addVehiclePlate" placeholder="Enter Plate Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Vehicle Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVehicleType" name="addVehicleType">
                                        <option value="">Select type</option>
                                        <option value="Saloon">Saloon</option>
                                        <option value="Estate">Estate</option>
                                        <option value="Motorbike">Motorbike</option>
                                        <option value="Bus">Bus</option>
                                        <option value="MiniBus">MiniBus</option>
                                        <option value="Excavator">Excavator</option>
                                        <option value="Pickup">Pickup</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Select Fuel Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addVehicleFuelType" name="addVehicleFuelType">
                                        <option value="">Select type</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Petrol">Petrol</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Registration Date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="addVehicleRegistrationDate" placeholder="Select Date of Registration">
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_driver_picker" multiple data-live-search="true" id="addVehicleDriverSelect" name="addVehicleDriverSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_company_vehicle_picker" onchange="getCompanyBranches(this)" data-live-search="true" id="addVehicleCompanySelect" name="addVehicleCompanySelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="addVehicleCompanyBranchSelect" name="addVehicleCompanyBranchSelect">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addVehicleBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- edit Vehicles -->
    <div id="editVehiclesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayVehicleName"></span> Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-car"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehicleName" placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Make</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehicleMake" placeholder="Enter Make">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Model</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehicleModel" placeholder="Enter Model">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Number Plate</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-info"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editVehiclePlate" placeholder="Enter Plate Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Vehicle Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editVehicleType" name="addVehicleType">
                                        <option value="">Select type</option>
                                        <option value="Saloon">Saloon</option>
                                        <option value="Estate">Estate</option>
                                        <option value="Motorbike">Motorbike</option>
                                        <option value="Bus">Bus</option>
                                        <option value="MiniBus">MiniBus</option>
                                        <option value="Excavator">Excavator</option>
                                        <option value="Pickup">Pickup</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Select Fuel Type</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="editVehicleFuelType" name="addVehicleFuelType">
                                        <option value="">Select type</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Petrol">Petrol</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">

                                <label class="form-control-label d-flex ">Registration Date</label>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="la la-calendar"></i>
                                        </span>

                                        <input type="text" class="form-control" id="editVehicleRegistrationDate" placeholder="Select Date of Registration">
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Driver</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control edit_driver_selected_picker" multiple data-live-search="true" id="editVehicleDriverSelect" name="editVehicleDriverSelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Company</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control select_company_edit_vehicle_picker" onchange="getCompanyBranches(this)" data-live-search="true" id="editVehicleCompanySelect" name="editVehicleCompanySelect">
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Branch</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" data-live-search="true" id="editVehicleCompanyBranchSelect" name="editVehicleCompanyBranchSelect">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editVehicleBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Show more details of user -->
    <div id="moreDetailsAdminUserData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <p>Full Name:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminFullname"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Username:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminUsername"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Email:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminEmail"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Created By:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminCreatedBy"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Created Date:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminCreatedDate"></p>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal to edit users-->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayEditUserName"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Full Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editFullName" placeholder="Full Name">
                                    </div>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editUserBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/components/manage_app_customers.js')}}"></script>
@endpush