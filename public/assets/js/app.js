// GLOBAL VARIABLES DECLARATIONS

// API DECLARATIONS
var loginApi = "/loginApi";

var getCountriesArrayApi = "/getCountriesArrayApi";
var getIndustriesArrayApi = "/getIndustriesArrayApi";
var getCustomersArrayApi = "/getCustomersArrayApi";
var getAllBranchesArrayApi = "/getAllBranchesArrayApi";

// Page View Routes
var dashboardViewRoute = "/";


var subscriberStartDate = "";
var subscriberEndDate = "";

var allStartDate = "";
var allEndDate = "";

var displayItemNameCounter = 0;
var showThirdPartyQtyCounter = 0;
var enterItemQtyCounter = 0;
var enterItemCounter = 0;
var showItemQtyCounter = 0;
var showItemCounter = 0;
var showItemCodesCounter = 0;
var showCodesCounter = 0;
var priceCounter = 0;
var itemPriceCounter = 0;

var userRoleSession = sessionStorage.getItem("userRoleSession");


// MONTHS
var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];


// execute this 
$(document).ready(function () {
    // $("#toggle-btn").trigger('click');
    // getStoredItem();

     // hide this by default on payments tab
     $("#voucherDiv").hide("fast");
     $("#editVoucherDiv").hide("fast");
     $("#companyAmountDiv").hide("fast");
     $("#multipleAmountDiv").hide("fast");
     $("#multipleOnlyDiv").hide("fast");

     // hide the add new driver button
     $("#addDriverBtn").hide("fast");
     $('#driverDisplayName').html(toTitleCase("Driver's Profile"));

     // driver rules btn
     $("#checkFillingStation").hide("fast");
     $("#checkProducts").hide("fast");
     $("#checkIncorrectPin").hide("fast");
     $("#checkPurchase").hide("fast");

     getStoredItem();
});

// On Login Check if enter key is pressed
$("#password").keyup(function (event) {
    if (event.keyCode === 13) {
        $("#loginBtn").click();
    }
});
/** RETRY BTN **/
$("#retryBtn").click(function (e) {
    location.reload();
});

/** CLOSE third party modal btn **/
$("#closeThirdPartyBtn").click(function (e) {
    $('#thirdPartyPickUpModal').modal('hide');

    $('#requestInvoiceModal').modal('show');
});


/** Remove Item in storge when logout BTN CLICK**/
$("#logoutBtn").click(function (e) {

    swal({
        title: "Are you sure?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            sessionStorage.clear();
            window.location.href = "/logout";
        });

});


// Logout Button on the dashboard when clicked
/** Remove Item in storge when logout BTN CLICK**/
$("#logoutDashBtn").click(function (e) {

    swal({
        title: "Are you sure?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            sessionStorage.clear();
            window.location.href = "/logout";
        });

});

// Dashboard tabs when clicked

// /**Handle Admin Users Tabs Options **/
// $("#base-tab-1").click(function (e) {
//     getAdminUsersData();

// });

// /**Handle Branch Tabs here **/
// $("#base-tab-2a").click(function (e) {
//     getBranchUsersData();

// });

// /**Handle Contact Tabs here **/
// $("#base-tab-2b").click(function (e) {
//     getContactUsersData();

// });

// /**Handle Contries Tabs here **/
// $("#base-tab-2c").click(function (e) {
//     getCountriesUsersData();

// });

// /**Handle Wallets Tabs here **/
// $("#base-tab-2d").click(function (e) {
//     getWalletUsersData();

// });

// /**Handle Industries Tabs here **/
// $("#base-tab-2e").click(function (e) {
//     getIndustriesUsersData();

// });


/** LOGIN API **/
$("#loginBtn").click(function (e) {
    e.preventDefault();
    show_loader();
    var username = $('#username').val();
    var password = $('#password').val();

    if ((username == "" || username == undefined) && (password == "" || password == undefined)) {
        displayErrorMsg("Username and password must be filled"); //display Error message
        return false;
    }
    else if (username == "" || username == undefined) {
        displayErrorMsg("Username must be filled"); //display Error message
        return false;
    }
    else if (password == "" || password == undefined) {
        displayErrorMsg("Password must be filled"); //display Error message
        return false;
    }

    else {

        $("#loginBtn").prop("disabled", true);
        var formData = {
            "username": username,
            "password": password
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: loginApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            console.log(JSON.stringify(data));
            // console.log(JSON.stringify(data.RESPONSE_EXTRA["EMAIL"]));
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("loginForm").reset();
                $("#loginBtn").removeAttr('disabled');

                // Save data to sessionStorage
                sessionStorage.setItem('username', username);
                sessionStorage.setItem('userEmail', data.RESPONSE_EXTRA["EMAIL"].toLowerCase());

                window.location.href = dashboardViewRoute;

                displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else if (data.RESPONSE_CODE == "401") {
                hide_loader();
                $("#loginBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }

            else {
                hide_loader();
                $("#loginBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(jqXHR.status);
            $("#loginBtn").removeAttr('disabled');
            if (jqXHR.status == "401") {
                displayErrorMsg("Invalid Username or Password"); //display Error message
            } else {
                displayErrorMsg("Sorry, connection to server failed. Please try again");
            }

        });

    }

});


//Get stored item from storage with this function
function getStoredItem() {
    // Get saved data from sessionStorage
    var tabToGoto = sessionStorage.getItem('tabToGoto');

    // for FUEL STATIONS
    if (tabToGoto == "omcTab") {
        $("#base-tab-2d").click();
    }

    if (tabToGoto == "fuelStationTab") {
        $("#base-tab-1").click();
    }

    if (tabToGoto == "clusteredTab") {
        $("#base-tab-2J").click();
    }

    if (tabToGoto == "attendantTab") {
        $("#base-tab-2a").click();
    }

    if (tabToGoto == "posTab") {
        $("#base-tab-2c").click();
    }

    if (tabToGoto == "paymentTab") {
        $("#base-tab-2e").click();
    }

    if (tabToGoto == "purchaseTab") {
        $("#base-tab-2f").click();
    }

    if (tabToGoto == "driverTab") {
        $("#base-tab-2j").click();
    }

    if (tabToGoto == "vehicleTab") {
        $("#base-tab-2k").click();
    }

    // for Company
    if (tabToGoto == "customerTab") {
        $("#base-tab-1").click();
    }

    if (tabToGoto == "branchTab") {
        $("#base-tab-2a").click();
    }

    if (tabToGoto == "contactTab") {
        $("#base-tab-2b").click();
    }

    if (tabToGoto == "countryTab") {
        $("#base-tab-2c").click();
    }

    if (tabToGoto == "voucherTab") {
        $("#base-tab-2g").click();
    }

    if (tabToGoto == "driverVoucherTab") {
        $("#base-tab-2Q").click();
    }

    if (tabToGoto == "customerPaymentTab") {
        $("#base-tab-2h").click();
    }

    if (tabToGoto == "walletTab") {
        $("#base-tab-2d").click();
    }

    if (tabToGoto == "walletTab2") {
        $("#base-tab-2k").click();
    }

    if (tabToGoto == "industryTab") {
        $("#base-tab-2e").click();
    }

    //for fleet manager
    if (tabToGoto == "fleetPendingRequestTab") {
        $("#base-tab-pending").click();
    }


    // var username = sessionStorage.getItem('username');

    // $("#showUsername").html(username);

}


// get all customers list
function getCustomersArray() {
    var request = $.ajax({
        url: getCustomersArrayApi,
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllCustomers(data.RESPONSE_DATA);
            console.log("success pull customers -->", data);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull customers");
    });

}

// this gets all the countries in the db
function loadAllCustomers(data) {

    // Clear the old data
    $('#addCustomerContact')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addBranchCompany')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addCustomerVoucherContact')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addPaymentCustomer')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addPurchaseCustomer')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addCompanyWallet')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#editCompanyWallet')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addDriverCompanySelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addVehicleCompanySelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#editVehicleCompanySelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addFleetManagerCompanySelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#editFleetManagerCompanySelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Company</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    if (data) {
        var select = $('#addCustomerContact');
        var select2 = $('#addPaymentCustomer');
        var select5 = $('#editPaymentCustomer');
        var select3 = $('#addPurchaseCustomer');
        var select4 = $('#editPurchaseCustomer');
        var select6 = $('#editCustomerContact');
        var select7 = $('#editCustomerVoucherContact');
        var select8 = $('#addCustomerVoucherContact');
        var select9 = $('#addBranchCompany');
        var select10 = $('#editBranchCompany');
        var select11 = $('#addCompanyWallet');
        var select12 = $('#editCompanyWallet');
        var select13 = $('#addDriverCompanySelect');
        var select14 = $('#addVehicleCompanySelect');
        var select15 = $('#editVehicleCompanySelect');
        var select16 = $('#addFleetManagerCompanySelect');
        var select17 = $('#editFleetManagerCompanySelect');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];
            select.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select2.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select3.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select4.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select5.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select6.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select7.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select8.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select9.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select10.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select11.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select12.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select13.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select14.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select15.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select16.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));
            select17.append($("<option></option>").attr("value", mainData["cust_id"]).text(mainData["full_name"]));

        }

        $('.customerContactSelectpicker').selectpicker();
        $('.select_voucher_customer_contact').selectpicker();
        $('.select_picker_branch_company').selectpicker();
        $('.select_wallet_company_picker').selectpicker();
        $('.paymentCustomerSelectpicker').selectpicker();
        $('.purchaseCustomerSelectpicker').selectpicker();
        $('.select_company_driver_picker').selectpicker();
        $('.select_company_vehicle_picker').selectpicker();
        $('.select_company_edit_vehicle_picker').selectpicker();
        $('.select_company_fleet_manager_picker').selectpicker();
        $('.edit_company_fleet_manager_picker').selectpicker();
    }

}

// get all pos list
function getPosArray() {
    var request = $.ajax({
        url: "/getPosArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllPos(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull pos");
    });

}

// this gets all the pos in the db
function loadAllPos(data) {

    // Clear the old data
    $('#addSelectedPos')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select POS </option>')
        .val('')
    // .append('<option value="new">New OMC</option>')
    // .val('new');

    // // Clear the old data
    // $('#addStationPos')
    //     .find('option')
    //     .remove()
    //     .end()
    //     .append('<option value="">Select POS </option>')
    //     .val('')
    // // .append('<option value="new">New OMC</option>')
    // // .val('new');


    if (data) {

        var select = $('#addSelectedPos');
        var select2 = $('#editSelectedPos');
        var select3 = $('#addStationPos');
        var select4 = $('#editStationPos');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["pos_id"]).text(mainData["make"] + " - " + mainData["model"]));
            select2.append($("<option></option>").attr("value", mainData["pos_id"]).text(mainData["make"] + " - " + mainData["model"]));
            select3.append($("<option></option>").attr("value", mainData["pos_id"]).text(mainData["make"] + " - " + mainData["model"]));
            select4.append($("<option></option>").attr("value", mainData["pos_id"]).text(mainData["make"] + " - " + mainData["model"]));

        }

        $('.selected_picker_attendant_pos').selectpicker();
        $('.select_picker_station_pos_add').selectpicker();
        $('.select_picker_station_pos_edit').selectpicker();

    }

}

// get all clustered omc list
function getClusteredArray() {
    var request = $.ajax({
        url: "/getClusteredArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllCluster(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull cluster");
    });

}

// this gets all the clusters in the db
function loadAllCluster(data) {


    // // Clear the old data
    $('#allowedOmcRules')
        .find('option')
        .remove()
        .end()
    // .append('<option value="">Select Cluster </option>')
    // .val('')
    // // .append('<option value="new">New OMC</option>')
    // // .val('new');


    if (data) {
        var select4 = $('#allowedOmcRules');
        var select5 = $('#allowedOmcRulesShow');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select4.append($("<option></option>").attr("value", mainData["cluster_id"]).text(mainData["name"]));
            select5.append($("<option></option>").attr("value", mainData["cluster_id"]).text(mainData["name"]));

        }
        $('.select_picker_rules_omc').selectpicker();
        $('.select_picker_rules_omc_update').selectpicker();

    }

}

// get all omcs list
function getOmcArray() {
    var request = $.ajax({
        url: "/getOmcArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllOmc(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull omc");
    });

}

// this gets all the countries in the db
function loadAllOmc(data) {

    // Clear the old data
    $('#addStationOMC')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select OMC </option>')
        .val('')
    // .append('<option value="new">New OMC</option>')
    // .val('new');

    // // Clear the old data
    // $('#allowedOmcRules')
    //     .find('option')
    //     .remove()
    //     .end()
    //     .append('<option value="">Select OMC </option>')
    //     .val('')
    // // .append('<option value="new">New OMC</option>')
    // // .val('new');


    if (data) {

        var select = $('#addStationOMC');
        var select2 = $('#editStationOMC');
        var select3 = $('#editFuelStationOmc');
        // var select4 = $('#allowedOmcRules');
        // var select5 = $('#allowedOmcRulesShow');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["omc_id"]).text(mainData["name"]));
            select2.append($("<option></option>").attr("value", mainData["omc_id"]).text(mainData["name"]));
            select3.append($("<option></option>").attr("value", mainData["omc_id"]).text(mainData["name"]));
            // select4.append($("<option></option>").attr("value", mainData["omc_id"]).text(mainData["name"]));
            // select5.append($("<option></option>").attr("value", mainData["omc_id"]).text(mainData["name"]));

        }

        $('.select_picker_omc').selectpicker();
        // $('.select_picker_rules_omc').selectpicker();
        // $('.select_picker_rules_omc_update').selectpicker();

    }

}

// get all countries list
function getCountriesArray() {
    var request = $.ajax({
        url: getCountriesArrayApi,
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            sessionStorage.setItem('allCountries', JSON.stringify(data.RESPONSE_DATA));
            loadAllCountries(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull countries");
    });

}

// this gets all the countries in the db
function loadAllCountries(data) {

    // Clear the old data
    $('#addCountry')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Country </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addBranchCountry')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Country </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addOmcCountry')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Country </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    if (data) {
        var select = $('#addCountry');
        var select2 = $('#addBranchCountry');
        var select3 = $('#addOmcCountry');
        var select4 = $('#editOmcCountry');
        var select5 = $('#editCountry');
        var select6 = $('#editBranchCountry');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["ccountry_id"]).text(mainData["country"]));
            select2.append($("<option></option>").attr("value", mainData["ccountry_id"]).text(mainData["country"]));
            select3.append($("<option></option>").attr("value", mainData["ccountry_id"]).text(mainData["country"]));
            select4.append($("<option></option>").attr("value", mainData["ccountry_id"]).text(mainData["country"]));
            select5.append($("<option></option>").attr("value", mainData["ccountry_id"]).text(mainData["country"]));
            select6.append($("<option></option>").attr("value", mainData["ccountry_id"]).text(mainData["country"]));

        }

        $('.select_picker_country').selectpicker();
        $('.select_picker_branch_country').selectpicker();
        $('.select_picker_omc_country').selectpicker();
    }

}

// get all industries list
function getIndustriesArray() {
    var request = $.ajax({
        url: getIndustriesArrayApi,
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllIndustries(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull industries");
    });

}

// this gets all the industries in the db
function loadAllIndustries(data) {

    // Clear the old data
    $('#addIndustry')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Industry </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    if (data) {
        var select = $('#addIndustry');
        var select2 = $('#editIndustry');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["industry_id"]).text(mainData["industry_name"]));
            select2.append($("<option></option>").attr("value", mainData["industry_id"]).text(mainData["industry_name"]));

        }

        $('.select_industries_picker').selectpicker();
    }

}

// get all branches list
function getAllBranchesArray() {
    var request = $.ajax({
        url: getAllBranchesArrayApi,
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllBranches(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull branches");
    });

}

// this gets all the branches in the db
function loadAllBranches(data) {

    // Clear the old data
    $('#addBranchSelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Branch </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addDriverBranchSelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Branch </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addVehicleBranchSelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Branch </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');


    if (data) {
        var select = $('#addBranchSelect');
        var select2 = $('#addVehicleBranchSelect');
        var select3 = $('#editVehicleBranchSelect');
        var select4 = $('#editBranchSelect');
        var select5 = $('#addDriverBranchSelect');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
            select2.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
            select3.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
            select4.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
            select5.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));

        }

        $('.select_branch_picker').selectpicker();
        $('.select_vehicle_branch_picker').selectpicker();
    }

}

// get all  devices list
function getAllDevicesArray() {
    var request = $.ajax({
        url: "/getDevicesArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllDevices(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull devices");
    });

}

// this gets all the devices in the db
function loadAllDevices(data) {

    // Clear the old data
    $('#addDeviceSelect')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Device </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    if (data) {
        var select = $('#addDeviceSelect');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["id"]).text(mainData["name"]));

        }

        $('.select_device_picker').selectpicker();
    }

}

// get all  vehicles list
function getAllVehiclesArray() {
    var request = $.ajax({
        url: "/getVehiclesArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllVehicles(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull vehicles");
    });

}

// this gets all the devices in the db
function loadAllVehicles(data) {

    if (data) {
        var select = $('#addDriverVehiclesSelect');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["veh_id"]).text(mainData["name"]));

        }

        $('.select_driver_vehicles_picker').selectpicker();
    }

}

// get all drivers list
function getAllDriversArray() {
    var request = $.ajax({
        url: "/getDriverArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllDrivers(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull drivers");
    });

}

// this gets all the drivers in the db
function loadAllDrivers(data) {

    // Clear the old data
    // $('#addVehicleDriverSelect')
    //     .find('option')
    //     .remove()
    //     .end()
    //     .append('<option value="">Select Driver</option>')
    //     .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addPaymentDriver')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Driver</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addPurchaseDriver')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Driver</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#editPurchaseDriver')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Driver</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    // Clear the old data
    $('#addPaymentDriverCustomer')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Driver</option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    if (data) {
        var select = $('#addVehicleDriverSelect');
        var select2 = $('#editVehicleDriverSelect');
        var select3 = $('#addPaymentDriver');
        var select4 = $('#editPaymentDriver');
        var select5 = $('#addPurchaseDriver');
        var select6 = $('#editPurchaseDriver');
        var select7 = $('#addPaymentDriverCustomer');
        var select8 = $('#editPaymentDriverCustomer');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select2.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select3.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select4.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select5.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select6.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select7.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));
            select8.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));

        }

        $('.select_driver_picker').selectpicker();
        $('.edit_driver_selected_picker').selectpicker();
        $('.paymentDriverSelectpicker').selectpicker();
        $('.purchaseDriverSelectpicker').selectpicker();
        $('.paymentDriverSelectpickerCustomer').selectpicker();
    }

}


// get all fuel stations list
function getFuelStationsArray() {
    var request = $.ajax({
        url: "/getFuelStationsArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadAllFuelStations(data.RESPONSE_DATA);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull fuel stations");
    });

}

// this gets all the industries in the db
function loadAllFuelStations(data) {

    // Clear the old data
    $('#addFuelStations')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Fuel Station </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addFuelStationsPos')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Fuel Station </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addFuelStationsPayment')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Fuel Station </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addFuelStationsPurchase')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Fuel Station </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addStationWallet')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Select Fuel Station </option>')
        .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    $('#addClusteredFuelStations')
        .find('option')
        .remove()
        .end()
    // .append('<option value="">Select Fuel Station </option>')
    // .val('')
    // .append('<option value="new">New Supplier</option>')
    // .val('new');

    if (data) {
        var select = $('#addFuelStations');
        var select2 = $('#addFuelStationsPos');
        var select3 = $('#addFuelStationsPayment');
        var select6 = $('#editFuelStationsPayment');
        var select4 = $('#addFuelStationsPurchase');
        var select5 = $('#editFuelStationsPurchase');
        var select7 = $('#editFuelStationsPos');
        var select8 = $('#editFuelStations');
        var select9 = $('#addClusteredFuelStations');
        var select10 = $('#editClusteredFuelStations');
        var select11 = $('#addStationWallet');
        var select12 = $('#editStationWallet');

        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            select.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select2.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select3.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select4.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select5.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select6.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select7.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select8.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select9.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select10.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select11.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));
            select12.append($("<option></option>").attr("value", mainData["station_id"]).text(mainData["name"]));

        }

        $('.select_fuel_stations_picker').selectpicker();
        $('.select_fuel_stations_picker_pos').selectpicker();
        $('.select_fuel_stations_picker_payment').selectpicker();
        $('.select_fuel_stations_picker_purchase').selectpicker();
        $('.select_clustered_fuel_stations').selectpicker();
        $('.select_clustered_edit_fuel_stations').selectpicker();
        $('.select_fuelStation_wallet_picker').selectpicker();
        $('.edit_fuelStation_wallet_picker').selectpicker();
    }

}

// get all vouchers list
// function getVouchersArray() {
//     var request = $.ajax({
//         url: "/getVouchersArrayApi",
//         type: "GET",
//         contentType: "application/json"
//     });

//     request.done(function (data) {
//         if (data.RESPONSE_CODE == "200") {
//             loadAllVouchers(data.RESPONSE_DATA);
//         }
//     });

//     // Handle when it failed to connect
//     request.fail(function (jqXHR, textStatus) {
//         console.log("Failed to pull vouchers");
//     });

// }

// // this gets all the vouchers in the db
// function loadAllVouchers(data) {

//     // Clear the old data
//     $('#addPaymentVoucherCode')
//         .find('option')
//         .remove()
//         .end()
//         .append('<option value="">Select Voucher </option>')
//         .val('')
//     // .append('<option value="new">New Supplier</option>')
//     // .val('new');


//     if (data) {
//         var select = $('#addPaymentVoucherCode');
//         var select2 = $('#editPaymentVoucherCode');


//         for (i = 0; i < data.length; i++) {
//             mainData = data[i];

//             select.append($("<option></option>").attr("value", mainData["fv_id"]).text(mainData["voucher_code"]));
//             select2.append($("<option></option>").attr("value", mainData["fv_id"]).text(mainData["voucher_code"]));

//         }

//         $('.select_voucher_picker').selectpicker();

//     }

// }


// This will make a call to get branches pertaining to a customer
function getCompanyBranches(selectedValue) {
    var value = selectedValue.value;

    console.log("selected", value);

    if (value == "" || value == undefined || value == null) {
        // Clear the old data
        $('#addWalletBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#addDriverCompanyBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#addVehicleCompanyBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#addVoucherCompanyBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#editVehicleCompanyBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Branch </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');
        return false;

    } else {
        //   lets get the voucher usage type
        show_modal_loader();

        var formData = {
            "customerId": value
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/getCustomerBranchesApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                // Clear the old data
                $('#addWalletBranchSelect')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Select Branch </option>')
                    .val('')
                // .append('<option value="new">New Supplier</option>')
                // .val('new');

                // // Clear the old data
                // $('#addDriverCompanyBranchSelect')
                //     .find('option')
                //     .remove()
                //     .end()
                //     .append('<option value="">Select Branch </option>')
                //     .val('')
                // // .append('<option value="new">New Supplier</option>')
                // // .val('new');

                // Clear the old data
                $('#addVehicleCompanyBranchSelect')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Select Branch </option>')
                    .val('')
                // .append('<option value="new">New Supplier</option>')
                // .val('new');

                // Clear the old data
                $('#addVoucherCompanyBranchSelect')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Select Branch </option>')
                    // .append('<option value="allBranch">All Branch </option>')
                    .val('')
                // .append('<option value="new">New Supplier</option>')
                // .val('new');

                var allData = data.RESPONSE_DATA;

                if (allData) {
                    // console.log("alldata", allData);

                    var select = $('#addWalletBranchSelect');
                    var select2 = $('#editWalletBranchSelect');
                    var select3 = $('#addDriverCompanyBranchSelect');
                    var select4 = $('#addVehicleCompanyBranchSelect');
                    var select5 = $('#editVehicleCompanyBranchSelect');
                    var select6 = $('#addVoucherCompanyBranchSelect');


                    for (i = 0; i < allData.length; i++) {
                        mainData = allData[i];

                        select.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
                        select2.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
                        select3.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
                        select4.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
                        select5.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));
                        select6.append($("<option></option>").attr("value", mainData["custb_id"]).text(mainData["name"]));

                    }

                    $('.select_wallet_branch_picker').selectpicker();
                    $('.select_branch_driver_picker').selectpicker();

                }

                displaySuccessMsgModal(data.RESPONSE_MESSAGE);


            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get customer branches");
        });

    }
}

// This will make a call to get drivers pertaining to a branch
function getCompanyBranchesDrivers(selectedValue) {
    var value = selectedValue.value;

    console.log("selected", value);

    if (value == "" || value == undefined || value == null) {
        // Clear the old data
        $('#addVoucherCompanyDriverBranchSelect')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select driver </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');



    } else {
        //   lets get the voucher usage type
        show_modal_loader();

        var formData = {
            "branchId": value
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/getCustomerBranchesDriversApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                // // Clear the old data
                // $('#addVoucherCompanyDriverBranchSelect')
                //     .find('option')
                //     .remove()
                //     .end()
                //     .append('<option value="">Select drivers </option>')
                //     .val('')
                // // .append('<option value="new">New Supplier</option>')
                // // .val('new');


                var allData = data.RESPONSE_DATA;

                if (allData) {
                    // console.log("alldata", allData);

                    var select = $('#addVoucherCompanyDriverBranchSelect');

                    for (i = 0; i < allData.length; i++) {
                        mainData = allData[i];

                        select.append($("<option></option>").attr("value", mainData["driver_id"]).text(mainData["name"]));

                    }

                    $('.select_drivers_per_branch_picker').selectpicker();

                }

                displaySuccessMsgModal(data.RESPONSE_MESSAGE);

            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get customer branches");
        });

    }
}



// Convert formdata to Json Array
$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};



//AJAX SETUP
$.ajaxSetup({
    timeout: 60000,
    cache: false,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Cache-Control': 'no-cache, no-store, must-revalidate',
        'Pragma': 'no-cache',
        'Expires': '0'
    }
});


/** UTILITIES FUNCTIONS STARTS HERE **/

function randomString() {
    var length = 15;
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}
function generateInvoiceNumber() {
    var invNo = "P2/E/" + "" + Math.floor((Math.random() * 10000) + 1)
    return invNo;
}

function userRandomString() {
    var length = 10;
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}

function itemRandomString() {
    var length = 5;
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return "P2-" + result;
}

function categoryRandomString() {
    var length = 8;
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return "P2-" + result;
}

//TO SENTENCE CASE
function toTitleCase(str) {
    if (str == "" || str == undefined) {
        return str
    }

    else {
        return str.replace(
            /\w\S*/g,
            function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        );
    }
}


//RETURN BOOLEAN VALUES
function getBoolean(value) {
    switch (value) {
        case true:
        case "true":
        case 1:
        case "1":
        case "on":
        case "yes":
            return true;
        default:
            return false;
    }
}

// thousand seperators
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

//round to 2 decimal place
function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}


/**
 *Show Loader Functions
 */
function show_loader() {
    //    if (msg == '' || msg == undefined){
    //        msg="Loading...";
    //    }
    $(".loader").html('<div align="center" style="margin:0 auto; margin-top:30px;" class="text-center">' +
        '<div class="-spinner-ring -error-"></div>' +
        '</div>')
    $(".loader").show("fast");
}

/**
 *Hide Loader Functions
 */
function hide_loader() {
    $(".loader").html("")
    $(".loader").hide("fast");
}

function displaySuccessMsg(msg) {
    hide_loader();

    $(".msgAlertPlaceHolder").html("<div class='alert alert-success alert-dismissable fadeIn'><p class='text-center'>" +
        msg + "</p></div>");
    setTimeout(function () {
        $(".msgAlertPlaceHolder").html('');
    }, 7000);
}

function displayErrorMsg(msg) {
    hide_loader();
    $(".msgAlertPlaceHolder").html("<div class='alert alert-danger alert-dismissable fadeIn'><p class='text-center'>" +
        msg + "</p></div>");
    $(".loader").show('fast');
    setTimeout(function () {
        $(".msgAlertPlaceHolder").html('');
    }, 5000);
}

function displaySuccessToast(head, msg) {
    hide_loader();

    $.toast({
        heading: head,
        text: msg,
        position: 'top-right',
        loaderBg: '#f83600',
        icon: 'success',
        hideAfter: 3500,
        stack: 6
    });
}


/**
 *Show Modal Loader Functions
 */
function show_modal_loader() {
    //    if (msg == '' || msg == undefined){
    //        msg="Loading...";
    //    }
    $(".modal_loader").html('<div align="center" style="margin:0 auto; margin-top:30px;" class="text-center">' +
        '<div class="-spinner-ring -error-"></div>' +
        '</div>')
    $(".modal_loader").show("fast");
}

/**
 *Hide modal Loader Functions
 */
function hide_modal_loader() {
    $(".modal_loader").html("")
    $(".modal_loader").hide("fast");
}

function displayErrorMsgModal(msg) {
    //hide loader
    hide_modal_loader();

    $(".modalAlertPlaceHolder").html("<div class='alert alert-danger alert-dismissable fadeIn'><p class='text-left'>" +
        msg + "</p></div>");
    setTimeout(function () {
        $(".modalAlertPlaceHolder").html('');
    }, 5000);
}

function displaySuccessMsgModal(msg) {
    hide_modal_loader();

    $(".modalAlertPlaceHolder").html("<div class='alert alert-success alert-dismissable fadeIn'><p class='text-center'>" +
        msg + "</p></div>");
    setTimeout(function () {
        $(".modalAlertPlaceHolder").html('');
    }, 7000);
}

function displaySuccessToastModal(head, msg) {
    hide_modal_loader();

    $.toast({
        heading: head,
        text: msg,
        position: 'top-right',
        loaderBg: '#f83600',
        icon: 'success',
        hideAfter: 3500,
        stack: 6
    });
}

function addslashes(str) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}

function removeInvalidCharactersFromJson(jsonString) {
    JSON.parse(jsonString.replace(/"([\w\s]+)":/g, function (m) {
        return m.replace(/\s+/g, '_');
    }));

}


function utoa(str) {
    return window.btoa(unescape(encodeURIComponent(str)));
}

function atou(str) {
    return decodeURIComponent(escape(window.atob(str)));
}