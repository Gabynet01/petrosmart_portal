var userRoleSession = sessionStorage.getItem("userRoleSession");

var addPetrosmartCustomerApi = "/addPetrosmartCustomerApi";
var addPetrosmartIndustryApi = "/addPetrosmartIndustryApi";
var addPetrosmartCountryApi = "/addPetrosmartCountryApi";
var addPetrosmartBranchApi = "/addPetrosmartBranchApi";
var addPetrosmartContactApi = "/addPetrosmartContactApi";
var addPetrosmartWalletApi = "/addPetrosmartWalletApi";

var editAdminUserApi = "/editAdminUserApi";
var deleteAdminUserApi = "/deleteAdminUserApi";

$(document).ready(function () {
    show_loader();
    show_modal_loader();

    setTimeout(function () {
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
    }, 1000);

    setTimeout(function () { getAdminUsersData(); }, 2000);
    setTimeout(function () { getBranchUsersData(); }, 2500);
    setTimeout(function () { getContactUsersData(); }, 3000);
    setTimeout(function () { getFuelVouchersData(); }, 3500);
    setTimeout(function () { getDriverFuelVouchersData(); }, 3800);
    setTimeout(function () { getCountriesUsersData(); }, 4000);
    setTimeout(function () { getWalletUsersData(); }, 4500);
    setTimeout(function () { getIndustriesUsersData(); }, 5000);
    setTimeout(function () { getPaymentData(); }, 5500);
    setTimeout(function () { getDriverData(); }, 6000);
    setTimeout(function () { getVehicleData(); }, 6500);

    setTimeout(function () { dateOfBirthPicker(); }, 7000);
    setTimeout(function () { addTimeOfDayToCard(); }, 7100);
    setTimeout(function () { addTimeOfDayToCardShow(); }, 7200);
    setTimeout(function () { editDateOfBirthPicker(); }, 7300);
    setTimeout(function () { dateOfBirthDriverPicker(); }, 7400);
    setTimeout(function () { registrationDatePicker(); }, 7500);
    setTimeout(function () { editregistrationDatePicker(); }, 7600);

    setTimeout(function () { getCustomersArray(); }, 8000);
    setTimeout(function () { getCountriesArray(); }, 8500);
    setTimeout(function () { getIndustriesArray(); }, 9000);
    setTimeout(function () { getAllBranchesArray(); }, 9500);
    setTimeout(function () { getOmcArray(); }, 10000);

    setTimeout(function () { getClusteredArray(); }, 10500);
    setTimeout(function () { getFuelStationsArray(); }, 11000);
    setTimeout(function () { getAllDevicesArray(); }, 11500);
    setTimeout(function () { getAllVehiclesArray(); }, 12000);
    setTimeout(function () { getAllDriversArray(); }, 12500);

    setTimeout(function () { voucherExpiryDatePicker(); }, 13000);

    setTimeout(function () {
        hide_loader();
        hide_modal_loader();
    }, 13500);

});

/** ADD USER API **/

$("#addUserBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var full_name = $('#addFullname').val();
    var address = $('#addAddress').val();
    var industry = $('#addIndustry').val();
    var gps = $('#addGps').val();
    var country = $('#addCountry').val();


    if ((full_name == "" || full_name == undefined) && (address == "" || address == undefined) && (industry == "" || industry == undefined)) {
        displayErrorMsgModal("All fields are required"); //display Error message
        return false;
    } else if (full_name == "" || full_name == undefined) {
        displayErrorMsgModal("Fullname must be filled"); //display Error message
        return false;
    } else if (address == "" || address == undefined) {
        displayErrorMsgModal("Address must be filled"); //display Error message
        return false;
    } else if (industry == "" || industry == undefined) {
        displayErrorMsgModal("Industry must be filled"); //display Error message
        return false;
    } else if (gps == "" || gps == undefined) {
        displayErrorMsgModal("GPS must be filled"); //display Error message
        return false;
    } else if (country == "" || country == undefined) {
        displayErrorMsgModal("Country must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addUserBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "address": address,
            "industry": industry,
            "full_name": full_name,
            "gps": gps,
            "country": country,
            "app_user_id": user_id
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartCustomerApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addUserForm").reset();
                $("#addUserBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'customerTab');

                console.log(data);
                location.reload();

                $('#addUserModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addUserBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addUserBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD CONTACT API **/
$("#addContactBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCustomerContact = $('#addCustomerContact').val();
    var addEmailContact = $('#addEmailContact').val();
    var addTelephoneContact = $('#addTelephoneContact').val();
    var addMobileContact = $('#addMobileContact').val();

    if (addCustomerContact == "" || addCustomerContact == undefined) {
        displayErrorMsgModal("Please select a customer"); //display Error message
        return false;
    } else if (addEmailContact == "" || addEmailContact == undefined) {
        displayErrorMsgModal("Email must be filled"); //display Error message
        return false;
    } else if (addTelephoneContact == "" || addTelephoneContact == undefined || addTelephoneContact == NaN) {
        displayErrorMsgModal("Telephone must be filled"); //display Error message
        return false;
    } else if (addMobileContact == "" || addMobileContact == undefined || addMobileContact == NaN) {
        displayErrorMsgModal("Mobile must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addContactBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addCustomerContact": addCustomerContact,
            "addEmailContact": addEmailContact,
            "addTelephoneContact": addTelephoneContact,
            "addMobileContact": addMobileContact
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartContactApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addContactForm").reset();
                $("#addContactBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'contactTab');

                console.log(data);
                location.reload();

                $('#addContactModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addContactBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addContactBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD INDUSTRY API **/
$("#addIndustryBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addIndustryName = $('#addIndustryName').val();

    if (addIndustryName == "" || addIndustryName == undefined) {
        displayErrorMsgModal("Industry name must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addIndustryBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addIndustryName": addIndustryName
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartIndustryApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addIndustryForm").reset();
                $("#addIndustryBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'industryTab');

                console.log(data);
                location.reload();

                $('#addIndustryModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addIndustryBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addIndustryBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD COUNTRY API **/
$("#addCountryBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCountryName = $('#addCountryName').val();

    if (addCountryName == "" || addCountryName == undefined) {
        displayErrorMsgModal("Country name must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addCountryBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addCountryName": addCountryName
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartCountryApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addCountryForm").reset();
                $("#addCountryBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'countryTab');

                console.log(data);
                location.reload();

                $('#addCountryModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addCountryBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addCountryBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD BRANCH API **/
$("#addBranchBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addBranchCompany = $.trim($('#addBranchCompany').val());
    var addBranchName = $.trim($('#addBranchName').val());
    var addBranchAddress = $.trim($('#addBranchAddress').val());
    var addBranchGps = $.trim($('#addBranchGps').val());
    var addBranchContact1 = $.trim($('#addBranchContact1').val());
    var addBranchContact2 = $.trim($('#addBranchContact2').val());
    var addBranchCountry = $.trim($('#addBranchCountry').val());

    if (addBranchCompany == "" || addBranchCompany == undefined) {
        displayErrorMsgModal("Company name must be selected"); //display Error message
        return false;
    }

    if (addBranchName == "" || addBranchName == undefined) {
        displayErrorMsgModal("Branch name must be filled"); //display Error message
        return false;
    } else if (addBranchAddress == "" || addBranchAddress == undefined) {
        displayErrorMsgModal("Branch Address must be filled"); //display Error message
        return false;
    } else if (addBranchGps == "" || addBranchGps == undefined) {
        displayErrorMsgModal("Branch GPS must be filled"); //display Error message
        return false;
    } else if (addBranchContact1 == "" || addBranchContact1 == NaN || addBranchContact1 == undefined) {
        displayErrorMsgModal("Branch Contact 1 must be filled"); //display Error message
        return false;
    } else if (addBranchContact2 == "" || addBranchContact2 == NaN || addBranchContact2 == undefined) {
        displayErrorMsgModal("Branch Contact 2 must be filled"); //display Error message
        return false;
    } else if (addBranchCountry == "" || addBranchCountry == undefined) {
        displayErrorMsgModal("Country must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addBranchBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addBranchName": addBranchName,
            "addBranchCompany": addBranchCompany,
            "addBranchAddress": addBranchAddress,
            "addBranchGps": addBranchGps,
            "addBranchContact1": addBranchContact1,
            "addBranchContact2": addBranchContact2,
            "addBranchCountry": addBranchCountry
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartBranchApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addBranchForm").reset();
                $("#addBranchBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'branchTab');

                console.log(data);
                location.reload();

                $('#addBranchModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addBranchBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addBranchBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD WALLET API **/
$("#addWalletBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCompanyWallet = $.trim($('#addCompanyWallet').val());
    var addBranchSelect = $.trim($('#addWalletBranchSelect').val());
    var addTelco = $.trim($('#addTelco').val());
    var addWalletNum = $.trim($('#addWalletNum').val());
    var addAuthKey = $.trim($('#addAuthKey').val());
    var addMerchantToken = $.trim($('#addMerchantToken').val());

    if (addCompanyWallet == "" || addCompanyWallet == undefined) {
        displayErrorMsgModal("Please select a company"); //display Error message
        return false;
    }

    if (addBranchSelect == "" || addBranchSelect == undefined) {
        displayErrorMsgModal("Please select a branch"); //display Error message
        return false;
    } else if (addTelco == "" || addTelco == undefined) {
        displayErrorMsgModal("Please select a Telco"); //display Error message
        return false;
    } else if (addWalletNum == "" || addWalletNum == NaN || addWalletNum == undefined) {
        displayErrorMsgModal("Wallet Number must be filled"); //display Error message
        return false;
    } else if (addAuthKey == "" || addAuthKey == undefined) {
        displayErrorMsgModal("Authorization key must be filled"); //display Error message
        return false;
    } else if (addMerchantToken == "" || addMerchantToken == undefined) {
        displayErrorMsgModal("Merchant Token must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addWalletBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addCompanyWallet": addCompanyWallet,
            "addBranchSelect": addBranchSelect,
            "addTelco": addTelco,
            "addWalletNum": addWalletNum,
            "addAuthKey": addAuthKey,
            "addMerchantToken": addMerchantToken
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addPetrosmartWalletApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addWalletForm").reset();
                $("#addWalletBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'walletTab');

                console.log(data);
                location.reload();

                $('#addWalletModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addWalletBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addWalletBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD FUEL VOUCHERS API **/

$("#addVoucherBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addCustomerContact = $.trim($('#addCustomerVoucherContact').val());
    var addVoucherType = $.trim($('#addVoucherType').val());
    var addVoucherAmount = $.trim($('#addVoucherAmount').val());
    var addVoucherCompanyBranchSelect = $.trim($('#addVoucherCompanyBranchSelect').val());
    var addVoucherCompanyDriverBranchSelect = $.trim($('#addVoucherCompanyDriverBranchSelect').val());
    var addVoucherExpiryDate = $.trim($('#voucherExpiryDate').val());


    if (addCustomerContact == "" || addCustomerContact == undefined) {
        displayErrorMsgModal("Please Select Company"); //display Error message
        return false;
    } else if (addVoucherType == "" || addVoucherType == undefined) {
        displayErrorMsgModal("Please select voucher type"); //display Error message
        return false;
    } else if (addVoucherAmount == "" || addVoucherAmount == undefined) {
        displayErrorMsgModal("Please enter voucher amount"); //display Error message
        return false;
    } else if (addVoucherCompanyBranchSelect == "" || addVoucherCompanyBranchSelect == undefined) {
        displayErrorMsgModal("Please select branch"); //display Error message
        return false;
    } else if (addVoucherCompanyDriverBranchSelect == "" || addVoucherCompanyDriverBranchSelect == undefined) {
        displayErrorMsgModal("Please select driver"); //display Error message
        return false;
    } else if (addVoucherExpiryDate == "" || addVoucherExpiryDate == undefined) {
        displayErrorMsgModal("Please select expiry date"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // based on the number of drivers
        var allDrivers = addVoucherCompanyDriverBranchSelect.split(",");
        var driverCount = allDrivers.length;
        var totalAmount;
        var jsonDriver = {};
        var driverArray = [];
        if (driverCount > 0) {

            // calculate total amount from the unit amount from the number of drivers
            totalAmount = addVoucherAmount * driverCount;

            // let generate voucher codes for the selected drivers
            for (i = 0; i < driverCount; i++) {
                jsonDriver = {}

                jsonDriver["parent_voucher_id"] = user_id;
                jsonDriver["voucher_id"] = userRandomString();
                jsonDriver["voucher_code"] = itemRandomString();
                jsonDriver["voucher_type"] = addVoucherType;
                jsonDriver["driver_id"] = allDrivers[i];
                jsonDriver["unit_amount"] = addVoucherAmount;
                jsonDriver["expiry_date"] = addVoucherExpiryDate;

                driverArray.push(jsonDriver);
            }

        }

        $("#addVoucherBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addVoucherCode": utoa(JSON.stringify(driverArray)),
            "driverVouchersList": JSON.stringify(driverArray),
            "addCustomerContact": addCustomerContact,
            "addVoucherType": addVoucherType,
            "addVoucherAmount": addVoucherAmount,
            "totalAmount": totalAmount,
            "addVoucherCompanyBranchSelect": addVoucherCompanyBranchSelect,
            "addVoucherCompanyDriverBranchSelect": addVoucherCompanyDriverBranchSelect,
            "addVoucherExpiryDate": addVoucherExpiryDate
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartFuelVouchersApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addVoucherBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'voucherTab');

                // console.log(data);
                location.reload();

                $('#addVoucherModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addVoucherBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addVoucherBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD Payment API **/
$("#addPaymentBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addPaymentCustomer = $.trim($('#addPaymentCustomer').val());
    var addFuelStationsPayment = $.trim($('#addFuelStationsPayment').val());
    var addPaymentType = $.trim($('#addPaymentType').val());
    var addCustomerVoucherCode = $.trim($('#addCustomerVoucherCode').val());
    var addPaymentDriver = $.trim($('#addPaymentDriver').val());
    var addCompanyAmount = $.trim($('#addCompanyAmount').val());
    var addMultipleUseAmount = $.trim($('#addMultipleUseAmount').val());
    var addVoucherType = $.trim($('#addVoucherTypeCustomer').val());


    if (addPaymentCustomer == "" || addPaymentCustomer == undefined) {
        displayErrorMsgModal("Please select a customer"); //display Error message
        return false;
    } else if (addFuelStationsPayment == "" || addFuelStationsPayment == undefined) {
        displayErrorMsgModal("Please select filling station"); //display Error message
        return false;
    } else if (addPaymentType == "" || addPaymentType == undefined) {
        displayErrorMsgModal("Please select payment type"); //display Error message
        return false;
    } else if (addPaymentDriver == "" || addPaymentDriver == undefined) {
        displayErrorMsgModal("Please select driver"); //display Error message
        return false;
    }

    // else if (addPaymentType.toUpperCase() == "VOUCHER") {
    //     if (addPaymentVoucherCode == "" || addPaymentVoucherCode == undefined || addPaymentVoucherCode == NaN) {
    //         displayErrorMsgModal("Please select the customer's voucher code"); //display Error message
    //         return false;
    //     }
    // }
    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addPaymentBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addPaymentCustomer": addPaymentCustomer,
            "addFuelStationsPayment": addFuelStationsPayment,
            "addPaymentType": addPaymentType,
            "addPaymentDriver": addPaymentDriver,
            "addCustomerVoucherCode": addCustomerVoucherCode,
            "addCompanyAmount": addCompanyAmount,
            "addVoucherType": addVoucherType,
            "addMultipleUseAmount": addMultipleUseAmount
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartPaymentApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addPaymentBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'customerPaymentTab');

                // console.log(data);
                location.reload();

                $('#addPaymentModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else if (data.RESPONSE_CODE == "204") {
                $("#addPaymentBtn").removeAttr('disabled');

                displayErrorMsgModal(data.RESPONSE_MESSAGE);
            } else {
                $("#addPaymentBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
            // if (jqXHR.status == "204") {
            //     $("#addPaymentBtn").removeAttr('disabled');
            //     displayErrorMsgModal(data.RESPONSE_MESSAGE);
            // }

            // else {
            //     //show the error message
            $("#addPaymentBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
            // }
        });

    }

});

/** ADD Vehicle API **/
$("#addVehicleBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addVehicleName = $.trim($('#addVehicleName').val());
    var addVehicleMake = $.trim($('#addVehicleMake').val());
    var addVehicleModel = $.trim($('#addVehicleModel').val());
    var addVehicleType = $.trim($('#addVehicleType').val());
    var addVehiclePlate = $.trim($('#addVehiclePlate').val());
    var addVehicleFuelType = $.trim($('#addVehicleFuelType').val());
    var addVehicleRegistrationDate = $.trim($('#addVehicleRegistrationDate').val());
    var addVehicleDriverSelect = $.trim($('#addVehicleDriverSelect').val());
    var addVehicleCompanySelect = $.trim($('#addVehicleCompanySelect').val());
    var addVehicleBranchSelect = $.trim($('#addVehicleCompanyBranchSelect').val());

    if (addVehicleName == "" || addVehicleName == undefined) {
        displayErrorMsgModal("Vehicle Name must be filled"); //display Error message
        return false;
    } else if (addVehicleMake == "" || addVehicleMake == undefined) {
        displayErrorMsgModal("Make must be filled"); //display Error message
        return false;
    } else if (addVehicleModel == "" || addVehicleModel == undefined) {
        displayErrorMsgModal("Model must be filled"); //display Error message
        return false;
    } else if (addVehicleType == "" || addVehicleType == undefined) {
        displayErrorMsgModal("Type must be filled"); //display Error message
        return false;
    } else if (addVehicleType == "" || addVehicleType == undefined) {
        displayErrorMsgModal("Please select vehicle type"); //display Error message
        return false;
    } else if (addVehiclePlate == "" || addVehiclePlate == undefined) {
        displayErrorMsgModal("Please enter vehicle plate"); //display Error message
        return false;
    } else if (addVehicleFuelType == "" || addVehicleFuelType == undefined) {
        displayErrorMsgModal("Please select fuel type"); //display Error message
        return false;
    } else if (addVehicleDriverSelect == "" || addVehicleDriverSelect == undefined) {
        displayErrorMsgModal("Please select driver"); //display Error message
        return false;
    } else if (addVehicleBranchSelect == "" || addVehicleBranchSelect == undefined) {
        displayErrorMsgModal("Please select branch"); //display Error message
        return false;
    } else if (addVehicleCompanySelect == "" || addVehicleCompanySelect == undefined) {
        displayErrorMsgModal("Please select company"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addVehicleBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addVehicleName": addVehicleName,
            "addVehicleMake": addVehicleMake,
            "addVehicleModel": addVehicleModel,
            "addVehicleType": addVehicleType,
            "addVehiclePlate": addVehiclePlate,
            "addVehicleFuelType": addVehicleFuelType,
            "addVehicleRegistrationDate": addVehicleRegistrationDate,
            "addVehicleDriverSelect": addVehicleDriverSelect,
            "addVehicleBranchSelect": addVehicleBranchSelect,
            "addVehicleCompanySelect": addVehicleCompanySelect
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartVehicleApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addVehicleBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'vehicleTab');

                // console.log(data);
                location.reload();

                $('#addVehiclesModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addVehicleBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addVehicleBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});



// EDIT AND DELETE BUTTONS 

// handle branch button
$(document).on('click', '[data-customer-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-customer-edit'));

    $('#displayCustomerName').html(toTitleCase(jsonDetails.full_name));
    $('#editFullname').val(jsonDetails.full_name);
    $('#editAddress').val(jsonDetails.address);
    $('#editIndustry').val(jsonDetails.industry);
    $('#editGps').val(jsonDetails.gps);
    $('#editCountry').val(jsonDetails.country);


    $('#editUserModal').modal('show');

    /** EDIT USER API **/

    $("#editUserBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var user_id;
        var full_name = $('#editFullname').val();
        var address = $('#editAddress').val();
        var industry = $('#editIndustry').val();
        var gps = $('#editGps').val();
        var country = $('#editCountry').val();


        if ((full_name == "" || full_name == undefined) && (address == "" || address == undefined) && (industry == "" || industry == undefined)) {
            displayErrorMsgModal("All fields are required"); //display Error message
            return false;
        } else if (full_name == "" || full_name == undefined) {
            displayErrorMsgModal("Fullname must be filled"); //display Error message
            return false;
        } else if (address == "" || address == undefined) {
            displayErrorMsgModal("Address must be filled"); //display Error message
            return false;
        } else if (industry == "" || industry == undefined) {
            displayErrorMsgModal("Industry must be filled"); //display Error message
            return false;
        } else if (gps == "" || gps == undefined) {
            displayErrorMsgModal("GPS must be filled"); //display Error message
            return false;
        } else if (country == "" || country == undefined) {
            displayErrorMsgModal("Country must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editUserBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.cust_id,
                "address": address,
                "industry": industry,
                "full_name": full_name,
                "gps": gps,
                "country": country,
                "app_user_id": user_id
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartCustomerApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addUserForm").reset();
                    $("#editUserBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'customerTab');

                    console.log(data);
                    location.reload();

                    $('#editUserModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editUserBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editUserBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE CUSTOMER DATA
$(document).on('click', '[data-customer-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-customer-delete'));

    var formData = {
        "deleteType": "customer",
        "deleteId": jsonDetails.cust_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.full_name + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'customerTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});


// handle branch button
$(document).on('click', '[data-branch-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-branch-edit'));

    $('#displayBranchName').html(toTitleCase(jsonDetails.name));
    $('#editBranchCompany').val(jsonDetails.customer_selected);
    $('#editBranchName').val(jsonDetails.name);
    $('#editBranchAddress').val(jsonDetails.address);
    $('#editBranchGps').val(jsonDetails.gps);
    $('#editBranchContact1').val(jsonDetails.contact1);
    $('#editBranchContact2').val(jsonDetails.contact2);
    $('#editBranchCountry').val(jsonDetails.ccountry_id);

    $('#editBranchModal').modal('show');

    /** EDIT BRANCH API **/
    $("#editBranchBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addBranchCompany = $.trim($('#editBranchCompany').val());
        var addBranchName = $.trim($('#editBranchName').val());
        var addBranchAddress = $.trim($('#editBranchAddress').val());
        var addBranchGps = $.trim($('#editBranchGps').val());
        var addBranchContact1 = $.trim($('#editBranchContact1').val());
        var addBranchContact2 = $.trim($('#editBranchContact2').val());
        var addBranchCountry = $.trim($('#editBranchCountry').val());

        if (addBranchCompany == "" || addBranchCompany == undefined) {
            displayErrorMsgModal("Company name must be selected"); //display Error message
            return false;
        }

        if (addBranchName == "" || addBranchName == undefined) {
            displayErrorMsgModal("Branch name must be filled"); //display Error message
            return false;
        } else if (addBranchAddress == "" || addBranchAddress == undefined) {
            displayErrorMsgModal("Branch Address must be filled"); //display Error message
            return false;
        } else if (addBranchGps == "" || addBranchGps == undefined) {
            displayErrorMsgModal("Branch GPS must be filled"); //display Error message
            return false;
        } else if (addBranchContact1 == "" || addBranchContact1 == NaN || addBranchContact1 == undefined) {
            displayErrorMsgModal("Branch Contact 1 must be filled"); //display Error message
            return false;
        } else if (addBranchContact2 == "" || addBranchContact2 == NaN || addBranchContact2 == undefined) {
            displayErrorMsgModal("Branch Contact 2 must be filled"); //display Error message
            return false;
        } else if (addBranchCountry == "" || addBranchCountry == undefined) {
            displayErrorMsgModal("Country must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editBranchBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.custb_id,
                "addBranchCompany": addBranchCompany,
                "addBranchName": addBranchName,
                "addBranchAddress": addBranchAddress,
                "addBranchGps": addBranchGps,
                "addBranchContact1": addBranchContact1,
                "addBranchContact2": addBranchContact2,
                "addBranchCountry": addBranchCountry
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartBranchApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addBranchForm").reset();
                    $("#editBranchBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'branchTab');

                    // console.log(data);
                    location.reload();

                    $('#editBranchModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editBranchBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editBranchBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE BRANCH DATA
$(document).on('click', '[data-branch-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-branch-delete'));

    var formData = {
        "deleteType": "branch",
        "deleteId": jsonDetails.custb_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.name + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'branchTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// handle contact button
$(document).on('click', '[data-contact-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-contact-edit'));

    $('#displayContactName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#editCustomerContact').val(jsonDetails.full_name);
    $('#editEmailContact').val(jsonDetails.email);
    $('#editTelephoneContact').val(jsonDetails.tel);
    $('#editMobileContact').val(jsonDetails.mob);

    $('#editContactModal').modal('show');

    /** EDIT CONTACT API **/
    $("#editContactBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCustomerContact = $('#editCustomerContact').val();
        var addEmailContact = $('#editEmailContact').val();
        var addTelephoneContact = $('#editTelephoneContact').val();
        var addMobileContact = $('#editMobileContact').val();

        if (addCustomerContact == "" || addCustomerContact == undefined) {
            displayErrorMsgModal("Please select a customer"); //display Error message
            return false;
        } else if (addEmailContact == "" || addEmailContact == undefined) {
            displayErrorMsgModal("Email must be filled"); //display Error message
            return false;
        } else if (addTelephoneContact == "" || addTelephoneContact == undefined || addTelephoneContact == NaN) {
            displayErrorMsgModal("Telephone must be filled"); //display Error message
            return false;
        } else if (addMobileContact == "" || addMobileContact == undefined || addMobileContact == NaN) {
            displayErrorMsgModal("Mobile must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editContactBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.custc_id,
                "addCustomerContact": addCustomerContact,
                "addEmailContact": addEmailContact,
                "addTelephoneContact": addTelephoneContact,
                "addMobileContact": addMobileContact
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartContactApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addContactForm").reset();
                    $("#editContactBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'contactTab');

                    // console.log(data);
                    location.reload();

                    $('#editContactModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editContactBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editContactBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });




});

//DELETE CONTACT DATA
$(document).on('click', '[data-contact-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-contact-delete'));

    var formData = {
        "deleteType": "contact",
        "deleteId": jsonDetails.custc_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.customer_chosen + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'contactTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// handle country button
$(document).on('click', '[data-country-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-country-edit'));

    $('#displayCountryName').html(toTitleCase(jsonDetails.country));
    $('#editCountryName').val(jsonDetails.country);

    $('#editCountryModal').modal('show');


    /** EDIT COUNTRY API **/
    $("#editCountryBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCountryName = $('#editCountryName').val();

        if (addCountryName == "" || addCountryName == undefined) {
            displayErrorMsgModal("Country name must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editCountryBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.ccountry_id,
                "addCountryName": addCountryName
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartCountryApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addCountryForm").reset();
                    $("#editCountryBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'countryTab');

                    // console.log(data);
                    location.reload();

                    $('#editCountryModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editCountryBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editCountryBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });





});

//DELETE COUNTRY DATA
$(document).on('click', '[data-country-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-country-delete'));

    var formData = {
        "deleteType": "country",
        "deleteId": jsonDetails.ccountry_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.country + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'countryTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// handle wallets button
$(document).on('click', '[data-wallet-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-wallet-edit'));

    $('#displayWalletName').html(toTitleCase(jsonDetails.wallet_num));
    $('#editCompanyWallet').val(jsonDetails.customer_selected);
    $('#editWalletBranchSelect').val(jsonDetails.custb_id);
    $('#editTelco').val(jsonDetails.telco);
    $('#editWalletNum').val(jsonDetails.wallet_num);
    $('#editAuthKey').val(jsonDetails.authorization_key);
    $('#editMerchantToken').val(jsonDetails.merchant_token);

    $('#editWalletModal').modal('show');

    /** EDIT WALLET API **/
    $("#editWalletBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCompanyWallet = $.trim($('#editCompanyWallet').val());
        var addBranchSelect = $.trim($('#editWalletBranchSelect').val());
        var addTelco = $.trim($('#editTelco').val());
        var addWalletNum = $.trim($('#editWalletNum').val());
        var addAuthKey = $.trim($('#editAuthKey').val());
        var addMerchantToken = $.trim($('#editMerchantToken').val());

        if (addBranchSelect == "" || addBranchSelect == undefined) {
            displayErrorMsgModal("Please select a branch"); //display Error message
            return false;
        } else if (addTelco == "" || addTelco == undefined) {
            displayErrorMsgModal("Please select a Telco"); //display Error message
            return false;
        } else if (addWalletNum == "" || addWalletNum == NaN || addWalletNum == undefined) {
            displayErrorMsgModal("Wallet Number must be filled"); //display Error message
            return false;
        } else if (addAuthKey == "" || addAuthKey == undefined) {
            displayErrorMsgModal("Authorization key must be filled"); //display Error message
            return false;
        } else if (addMerchantToken == "" || addMerchantToken == undefined) {
            displayErrorMsgModal("Merchant Token must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editWalletBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.custw_id,
                "addCompanyWallet": addCompanyWallet,
                "addBranchSelect": addBranchSelect,
                "addTelco": addTelco,
                "addWalletNum": addWalletNum,
                "addAuthKey": addAuthKey,
                "addMerchantToken": addMerchantToken
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartWalletApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addWalletForm").reset();
                    $("#editWalletBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'walletTab');

                    // console.log(data);
                    location.reload();

                    $('#editWalletModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editWalletBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editWalletBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });




});

//DELETE WALLET DATA
$(document).on('click', '[data-wallet-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-wallet-delete'));

    var formData = {
        "deleteType": "wallet",
        "deleteId": jsonDetails.custw_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.wallet_num + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'walletTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// handle industry button
$(document).on('click', '[data-industry-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-industry-edit'));

    $('#displayIndustryName').html(toTitleCase(jsonDetails.industry_name));
    $('#editIndustryName').val(jsonDetails.industry_name);

    $('#editIndustryModal').modal('show');

    /** EDIT INDUSTRY API **/
    $("#editIndustryBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addIndustryName = $('#editIndustryName').val();

        if (addIndustryName == "" || addIndustryName == undefined) {
            displayErrorMsgModal("Industry name must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editIndustryBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.industry_id,
                "addIndustryName": addIndustryName
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addPetrosmartIndustryApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addIndustryForm").reset();
                    $("#editIndustryBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'industryTab');

                    // console.log(data);
                    location.reload();

                    $('#editIndustryModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editIndustryBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editIndustryBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });


});

//DELETE INDUSTRY DATA
$(document).on('click', '[data-industry-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-industry-delete'));

    var formData = {
        "deleteType": "industry",
        "deleteId": jsonDetails.industry_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.industry_name + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'industryTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// handle voucher button
$(document).on('click', '[data-voucher-info]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-voucher-info'));

    $('#displayVoucherInfoName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#displayCompanyVname').html(jsonDetails.customer_chosen);
    $('#displayBranchVname').html(jsonDetails.branch_chosen);
    $('#displayTypeVname').html(jsonDetails.type_chosen);
    $('#displayTotalAmountVname').html(jsonDetails.amount);

    // lets generate the table

    var table_list = "";
    var driver_name;

    // lets get the driver name
    var driverNames = jsonDetails.driver_chosen.split(",");
    var driverIds = jsonDetails.drivers.split(",");

    var allData = JSON.parse(atou(jsonDetails.voucher_code));

    for (i = 0; i < allData.length; i++) {
        mainData = allData[i];

        table_list +=
            "<tr width='100%'>" +
            "<td>" + parseInt(i + 1) + "</td>" +
            "<td>" + driverNames[i] + "</td>" +
            "<td>" + mainData.voucher_code + "</td>" +
            "<td>" + mainData.unit_amount + "</td>" +
            "<td>" + jsonDetails.date_created + "</td>" +
            "<td>" + jsonDetails.voucher_expiry_date + "</td>"
    }


    $('#populateVoucherInfoBody').html(table_list);

    $('#voucherInfoDisplayTable').DataTable();

    $('#viewVoucherInfoModal').modal('show');


});
// handle voucher button
$(document).on('click', '[data-voucher-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-voucher-edit'));

    $('#displayVoucherName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#editCustomerVoucherContact').val(jsonDetails.customer);
    $('#editVoucherType').val(jsonDetails.voucher_type);
    $('#editVoucherAmount').val(jsonDetails.amount);
    $('#editVoucherExpiryDate').html(jsonDetails.expiry_date);


    $('#editVoucherModal').modal('show');

    /** EDIT FUEL VOUCHERS API **/

    $("#editVoucherBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addCustomerContact = $.trim($('#editCustomerVoucherContact').val());
        var addVoucherType = $.trim($('#editVoucherType').val());
        var addVoucherAmount = $.trim($('#editVoucherAmount').val());
        var addVoucherExpiryDate = $.trim($('#editVoucherExpiryDate').val());


        if (addCustomerContact == "" || addCustomerContact == undefined) {
            displayErrorMsgModal("Please Select Company"); //display Error message
            return false;
        } else if (addVoucherType == "" || addVoucherType == undefined) {
            displayErrorMsgModal("Please select voucher type"); //display Error message
            return false;
        } else if (addVoucherAmount == "" || addVoucherAmount == undefined) {
            displayErrorMsgModal("Please enter voucher amount"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();
            addVoucherCode = itemRandomString();

            $("#editVoucherBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.fv_id,
                "addVoucherCode": addVoucherCode,
                "addCustomerContact": addCustomerContact,
                "addVoucherType": addVoucherType,
                "addVoucherAmount": addVoucherAmount,
                "addVoucherExpiryDate": addVoucherExpiryDate
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartFuelVouchersApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editVoucherBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'voucherTab');

                    // console.log(data);
                    location.reload();

                    $('#editVoucherModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editVoucherBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editVoucherBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });




});

//MAKE VOUCHER DATA INACTIVE
$(document).on('click', '[data-voucher-inactive]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-voucher-inactive'));

    var formData = {
        "voucherId": jsonDetails.voucher_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Deactivate " + jsonDetails.driver_chosen + " Vocuher?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deactivateDriverVoucherApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'driverVoucherTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// //DELETE VOUCHER DATA
// $(document).on('click', '[data-voucher-delete]', function (e) {

//     var jsonDetails = JSON.parse($(this).attr('data-voucher-delete'));

//     var formData = {
//         "deleteType": "voucher",
//         "deleteId": jsonDetails.fv_id
//     };

//     formData = JSON.stringify(formData);

//     swal({
//         title: "Delete " + jsonDetails.customer_chosen + "?",
//         text: "",
//         type: "warning",
//         showCancelButton: true,
//         closeOnConfirm: true,
//         showLoaderOnConfirm: true,
//         confirmButtonText: "Yes"
//     },

//         function () {
//             show_loader();

//             var request = $.ajax({
//                 url: "/deleteGlobalApi",
//                 type: "POST",
//                 data: formData,
//                 contentType: "application/json"
//             });

//             request.done(function (data) {
//                 if (data.RESPONSE_CODE == "200") {
//                     // set value in storage to remind tabs to load this 
//                     sessionStorage.setItem('tabToGoto', 'voucherTab');

//                     location.reload();
//                     displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

//                 } else {
//                     hide_loader();
//                     displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
//                 }
//             });

//             // Handle when it failed to connect
//             request.fail(function (jqXHR, textStatus) {
//                 console.log(textStatus);
//                 //show the error message
//                 displayErrorMsg("Sorry, something went wrong");
//             });

//         });

// });


// handle payment button
$(document).on('click', '[data-payment-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-payment-edit'));

    $('#displayPaymentName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#editPaymentCustomer').val(jsonDetails.customer);
    $('#editFuelStationsPayment').val(jsonDetails.station_id);
    $('#editPaymentType').val(jsonDetails.payment_type);
    $('#editPaymentVoucherCode').val(jsonDetails.voucher_id);
    $('#editPaymentDriver').val(jsonDetails.driver_selected);

    $('#editPaymentModal').modal('show');


    /** Edit Payment API **/
    $("#editPaymentBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addPaymentCustomer = $.trim($('#editPaymentCustomer').val());
        var addFuelStationsPayment = $.trim($('#editFuelStationsPayment').val());
        var addPaymentType = $.trim($('#editPaymentType').val());
        var addPaymentVoucherCode = $.trim($('#editPaymentVoucherCode').val());
        var addPaymentDriver = $.trim($('#editPaymentDriver').val());


        if (addPaymentCustomer == "" || addPaymentCustomer == undefined) {
            displayErrorMsgModal("Please select a customer"); //display Error message
            return false;
        } else if (addFuelStationsPayment == "" || addFuelStationsPayment == undefined) {
            displayErrorMsgModal("Please select filling station"); //display Error message
            return false;
        } else if (addPaymentType == "" || addPaymentType == undefined) {
            displayErrorMsgModal("Please select payment type"); //display Error message
            return false;
        } else if (addPaymentDriver == "" || addPaymentDriver == undefined) {
            displayErrorMsgModal("Please select driver"); //display Error message
            return false;
        }

        // else if (addPaymentType.toUpperCase() == "VOUCHER") {
        //     if (addPaymentVoucherCode == "" || addPaymentVoucherCode == undefined || addPaymentVoucherCode == NaN) {
        //         displayErrorMsgModal("Please select the customer's voucher code"); //display Error message
        //         return false;
        //     }
        // }
        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editPaymentBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.fpay_id,
                "addPaymentCustomer": addPaymentCustomer,
                "addFuelStationsPayment": addFuelStationsPayment,
                "addPaymentType": addPaymentType,
                "addPaymentDriver": addPaymentDriver,
                "addPaymentVoucherCode": addPaymentVoucherCode
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartPaymentApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editPaymentBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'customerPaymentTab');

                    // console.log(data);
                    location.reload();

                    $('#editPaymentModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editPaymentBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editPaymentBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });


});

//DELETE Payment DATA
$(document).on('click', '[data-payment-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-payment-delete'));

    var formData = {
        "deleteType": "payment",
        "deleteId": jsonDetails.fpay_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.customer_chosen + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'customerPaymentTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});



// Show drivers rules that has been set

$(document).on('click', '[data-driver-show-rules]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-driver-show-rules'));
    // console.log("jsondetails --> ", jsonDetails["set_rules"]);
    // console.log("relaxed mins");
    // console.log(JSON.parse(atou(jsonDetails.set_rules)));

    // var setRules = JSON.parse(atou(jsonDetails.set_rules));

    var selectedModule;
    var selectedId;
    var selectedGoTo;
    //lets check which rules is called to be set
    var module = $(this).attr('data-module-type');

    if (module.toUpperCase() == 'VEHICLE') {
        selectedModule = "VEHICLE";
        selectedId = jsonDetails.veh_id;
        selectedGoTo = "vehicleTab";

        $("#checkFillingStation").show("fast");
        $("#checkProducts").show("fast");
        $("#checkIncorrectPin").hide("fast");
        $("#checkPurchase").hide("fast");
    }

    if (module.toUpperCase() == 'DRIVER') {
        selectedModule = "DRIVER";
        selectedId = jsonDetails.driver_id;
        selectedGoTo = "driverTab";

        $("#checkFillingStation").hide("fast");
        $("#checkProducts").hide("fast");
        $("#checkIncorrectPin").show("fast");
        $("#checkPurchase").show("fast");
    }

    if (module.toUpperCase() == 'BRANCH') {
        selectedModule = "BRANCH";
        selectedId = jsonDetails.custb_id;
        selectedGoTo = "branchTab";
    }


    // get all rules set in the field

    var allData = JSON.parse(atou(jsonDetails.set_rules));

    // pick the first object in the array
    finalData = allData[0];

    $('#transactionVolumeLimitShow').val(finalData.transactionVolumeLimit);
    $('#dailyVolumeLimitShow').val(finalData.dailyVolumeLimit);
    $('#weeklyVolumeLimitShow').val(finalData.weeklyVolumeLimit);
    $('#dailyTransactionLimitShow').val(finalData.dailyTransactionLimit);
    $('#weeklyTransactionLimitShow').val(finalData.weeklyTransactionLimit);
    $('#dailyAmountLimitShow').val(finalData.dailyAmountLimit);
    $('#weeklyAmountLimitShow').val(finalData.weeklyAmountLimit);
    $('#addTimeOfDayToCardShow').val(finalData.addTimeOfDayToCard);
    $('#allowedOmcRulesShow').val(finalData.allowedOmcRules);
    $('#allowedProductRulesShow').val(finalData.allowedProductRules);
    $('#incorrectPinEntryShow').val(finalData.incorrectPinEntry);
    $('#cardLockPeriodTypeShow').val(finalData.cardLockPeriodType);
    $('#cardLockPeriodValueShow').val(finalData.cardLockPeriodValue);

    // set checkbox items checked via values set in array

    var initValues = finalData.weekDaysArray;

    $.each($("input[name='checkboxWeekDaysShow']"), function () {
        $(this).prop("checked", ($.inArray($(this).val(), initValues) != -1));
    });



    // select all allowed filling stations via values selected

    var hidValue = finalData.allowedOmcRules;

    console.log("hidValue", hidValue)

    if (hidValue == null || hidValue == undefined || hidValue == "") {

    } else {
        var selectedOptions = hidValue.split(",");
        for (var i in selectedOptions) {
            var optionVal = selectedOptions[i];
            $(".select_picker_rules_omc_update").find("option[value=" + optionVal + "]").prop("selected", "selected");
        }
        $('.select_picker_rules_omc_update').selectpicker('refresh')

    }


    $("#showDriverDisplayRulesName").html(jsonDetails.name);

    $('#showDriverRulesModal').modal('show');


    // when the update set rules button is clicked do the ffg
    // now lets pick the details

    $("#editDriverRulesBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var rulesData = [];

        var jsonRules = {};

        // push all the selected weekdays into this array
        var weekDaysArray = [];
        $.each($("input[name='checkboxWeekDaysShow']:checked"), function () {
            weekDaysArray.push($(this).val());
        });

        // lets pick the details
        var transactionVolumeLimit = $.trim($('#transactionVolumeLimitShow').val());
        var dailyVolumeLimit = $.trim($('#dailyVolumeLimitShow').val());
        var weeklyVolumeLimit = $.trim($('#weeklyVolumeLimitShow').val());
        var dailyTransactionLimit = $.trim($('#dailyTransactionLimitShow').val());
        var weeklyTransactionLimit = $.trim($('#weeklyTransactionLimitShow').val());
        var dailyAmountLimit = $.trim($('#dailyAmountLimitShow').val());
        var weeklyAmountLimit = $.trim($('#weeklyAmountLimitShow').val());
        var addTimeOfDayToCard = $.trim($('#addTimeOfDayToCardShow').val());
        var allowedOmcRules = $.trim($('#allowedOmcRulesShow').val());
        var allowedProductRules = $.trim($('#allowedProductRulesShow').val());
        var incorrectPinEntry = $.trim($('#incorrectPinEntryShow').val());
        var cardLockPeriodType = $.trim($('#cardLockPeriodTypeShow').val());
        var cardLockPeriodValue = $.trim($('#cardLockPeriodValueShow').val());


        // lets create the JSON structure for the rules data

        jsonRules["transactionVolumeLimit"] = transactionVolumeLimit;
        jsonRules["dailyVolumeLimit"] = dailyVolumeLimit;
        jsonRules["weeklyVolumeLimit"] = weeklyVolumeLimit;
        jsonRules["dailyTransactionLimit"] = dailyTransactionLimit;
        jsonRules["weeklyTransactionLimit"] = weeklyTransactionLimit;
        jsonRules["dailyAmountLimit"] = dailyAmountLimit;
        jsonRules["weeklyAmountLimit"] = weeklyAmountLimit;
        jsonRules["addTimeOfDayToCard"] = addTimeOfDayToCard;
        jsonRules["allowedOmcRules"] = allowedOmcRules;
        jsonRules["allowedProductRules"] = allowedProductRules;
        jsonRules["incorrectPinEntry"] = incorrectPinEntry;
        jsonRules["cardLockPeriodType"] = cardLockPeriodType;
        jsonRules["cardLockPeriodValue"] = cardLockPeriodValue;
        jsonRules["weekDaysArray"] = weekDaysArray;

        // push the data to an array

        rulesData.push(jsonRules);

        // console.log(JSON.stringify(rulesData));


        $("#editDriverRulesBtn").prop("disabled", true);

        var formData = {
            "selectedId": selectedId,
            "selectedModule": selectedModule,
            "rulesData": utoa(JSON.stringify(rulesData))
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/setRulesForDriversApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#editDriverRulesBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', selectedGoTo);

                // console.log(data);
                location.reload();

                $('#showDriverRulesModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#editDriverRulesBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#editDriverRulesBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    });

});


// handle drivers button
$(document).on('click', '[data-driver-rules]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-driver-rules'));

    var selectedModule;
    var selectedId;
    var selectedGoTo;
    //lets check which rules is called to be set
    var module = $(this).attr('data-module-type');

    if (module.toUpperCase() == 'VEHICLE') {
        selectedModule = "VEHICLE";
        selectedId = jsonDetails.veh_id;
        selectedGoTo = "vehicleTab";

        $("#checkFillingStation").show("fast");
        $("#checkProducts").show("fast");
        $("#checkIncorrectPin").hide("fast");
        $("#checkPurchase").hide("fast");
    }

    if (module.toUpperCase() == 'DRIVER') {
        selectedModule = "DRIVER";
        selectedId = jsonDetails.driver_id;
        selectedGoTo = "driverTab";

        $("#checkFillingStation").hide("fast");
        $("#checkProducts").hide("fast");
        $("#checkIncorrectPin").show("fast");
        $("#checkPurchase").show("fast");
    }

    if (module.toUpperCase() == 'BRANCH') {
        selectedModule = "BRANCH";
        selectedId = jsonDetails.custb_id;
        selectedGoTo = "branchTab";
    }


    $("#driverDisplayRulesName").html(jsonDetails.name);

    $('#DriverRulesModal').modal('show');


    // now lets pick the details

    $("#addDriverRulesBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var rulesData = [];

        var jsonRules = {};

        // push all the selected weekdays into this array
        var weekDaysArray = [];
        $.each($("input[name='checkboxWeekDays']:checked"), function () {
            weekDaysArray.push($(this).val());
        });

        // lets pick the details
        var transactionVolumeLimit = $.trim($('#transactionVolumeLimit').val());
        var dailyVolumeLimit = $.trim($('#dailyVolumeLimit').val());
        var weeklyVolumeLimit = $.trim($('#weeklyVolumeLimit').val());
        var dailyTransactionLimit = $.trim($('#dailyTransactionLimit').val());
        var weeklyTransactionLimit = $.trim($('#weeklyTransactionLimit').val());
        var dailyAmountLimit = $.trim($('#dailyAmountLimit').val());
        var weeklyAmountLimit = $.trim($('#weeklyAmountLimit').val());
        var addTimeOfDayToCard = $.trim($('#addTimeOfDayToCard').val());
        var allowedOmcRules = $.trim($('#allowedOmcRules').val());
        var allowedProductRules = $.trim($('#allowedProductRules').val());
        var incorrectPinEntry = $.trim($('#incorrectPinEntry').val());
        var cardLockPeriodType = $.trim($('#cardLockPeriodType').val());
        var cardLockPeriodValue = $.trim($('#cardLockPeriodValue').val());


        // lets create the JSON structure for the rules data

        jsonRules["transactionVolumeLimit"] = transactionVolumeLimit;
        jsonRules["dailyVolumeLimit"] = dailyVolumeLimit;
        jsonRules["weeklyVolumeLimit"] = weeklyVolumeLimit;
        jsonRules["dailyTransactionLimit"] = dailyTransactionLimit;
        jsonRules["weeklyTransactionLimit"] = weeklyTransactionLimit;
        jsonRules["dailyAmountLimit"] = dailyAmountLimit;
        jsonRules["weeklyAmountLimit"] = weeklyAmountLimit;
        jsonRules["addTimeOfDayToCard"] = addTimeOfDayToCard;
        jsonRules["allowedOmcRules"] = allowedOmcRules;
        jsonRules["allowedProductRules"] = allowedProductRules;
        jsonRules["incorrectPinEntry"] = incorrectPinEntry;
        jsonRules["cardLockPeriodType"] = cardLockPeriodType;
        jsonRules["cardLockPeriodValue"] = cardLockPeriodValue;
        jsonRules["weekDaysArray"] = weekDaysArray;

        // push the data to an array

        rulesData.push(jsonRules);

        console.log(JSON.stringify(rulesData));


        $("#addDriverRulesBtn").prop("disabled", true);

        var formData = {
            "selectedId": selectedId,
            "selectedModule": selectedModule,
            "rulesData": utoa(JSON.stringify(rulesData))
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/setRulesForDriversApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addDriverRulesBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', selectedGoTo);

                // console.log(data);
                location.reload();

                $('#DriverRulesModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            } else {
                $("#addDriverRulesBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addDriverRulesBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    });


});

// handle drivers button
$(document).on('click', '[data-driver-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-driver-edit'));

    $("#addNewDriverBtn").hide("fast");
    $("#addDriverBtn").show("fast");

    $('#driverDisplayName').html(toTitleCase(jsonDetails.name + "'s Profile"));

    $('#addDriverAddress').val(jsonDetails.address);
    $('#addDobDriver').val(jsonDetails.dob);
    $('#addDriverName').val(jsonDetails.name);
    $('#addDriverPhone').val(jsonDetails.mob);
    $('#addDriverEmail').val(jsonDetails.email);
    $('#addDeviceSelect').val(jsonDetails.device_id);
    $('#addDriverCompanySelect').val(jsonDetails.customer_id);
    $("#addDriverCompanySelect").change();
    $('#addDriverCompanyBranchSelect').val(jsonDetails.branch_id);

    // handle display of the selected vehicles 

    // lets display the selected vehicles since it more than one

    if (jsonDetails.vehicles_selected == null || jsonDetails.vehicles_selected == "" || jsonDetails.vehicles_selected == undefined) {
        // do nothing
    } else {

        var hidValue = jsonDetails.vehicles_selected;

        var selectedOptions = hidValue.split(",");
        for (var i in selectedOptions) {
            var optionVal = selectedOptions[i];
            $(".select_driver_vehicles_picker").find("option[value=" + optionVal + "]").prop("selected", "selected");
        }
        $('.select_driver_vehicles_picker').selectpicker('refresh')

    }

    $('#addDriversModal').modal('show');

    // Send the driver data here
    $("#addDriverBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addBranchSelect = $.trim($('#addDriverCompanyBranchSelect').val());
        var addDriverAddress = $.trim($('#addDriverAddress').val());
        var addDobDriver = $.trim($('#addDobDriver').val());
        var addDriverName = $.trim($('#addDriverName').val());
        var addDriverPhone = $.trim($('#addDriverPhone').val());
        var addDeviceSelect = $.trim($('#addDeviceSelect').val());
        var addDriverEmail = $.trim($('#addDriverEmail').val());
        var addDriverVehiclesSelect = $.trim($('#addDriverVehiclesSelect').val());
        var addDriverCompanySelect = $.trim($('#addDriverCompanySelect').val());

        $("#addDriverBtn").prop("disabled", true);
        var formData = {
            "driver_id": jsonDetails.driver_id,
            "addDriverCompanySelect": addDriverCompanySelect,
            "addBranchSelect": addBranchSelect,
            "addDriverAddress": addDriverAddress,
            "addDobDriver": addDobDriver,
            "addDriverName": addDriverName,
            "addDriverPhone": addDriverPhone,
            "addDeviceSelect": addDeviceSelect,
            "addDriverVehiclesSelect": addDriverVehiclesSelect,
            "addDriverEmail": addDriverEmail
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartDriverApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addDriverBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'driverTab');

                location.reload();

                $('#addDriversModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

            } else {
                $("#addDriverBtn").removeAttr('disabled');
                console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addDriverBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });


    });

});


// Send the driver data here
$("#addNewDriverBtn").click(function (e) {
    e.preventDefault();

    show_modal_loader();

    var addBranchSelect = $.trim($('#addDriverCompanyBranchSelect').val());
    var addDriverAddress = $.trim($('#addDriverAddress').val());
    var addDobDriver = $.trim($('#addDobDriver').val());
    var addDriverName = $.trim($('#addDriverName').val());
    var addDriverPhone = $.trim($('#addDriverPhone').val());
    var addDeviceSelect = $.trim($('#addDeviceSelect').val());
    var addDriverEmail = $.trim($('#addDriverEmail').val());
    var addDriverVehiclesSelect = $.trim($('#addDriverVehiclesSelect').val());
    var addDriverCompanySelect = $.trim($('#addDriverCompanySelect').val());


    $("#addNewDriverBtn").prop("disabled", true);

    user_id = userRandomString();
    var formData = {
        "driver_id": user_id,
        "addDriverCompanySelect": addDriverCompanySelect,
        "addBranchSelect": addBranchSelect,
        "addDriverAddress": addDriverAddress,
        "addDobDriver": addDobDriver,
        "addDriverName": addDriverName,
        "addDriverPhone": addDriverPhone,
        "addDeviceSelect": addDeviceSelect,
        "addDriverVehiclesSelect": addDriverVehiclesSelect,
        "addDriverEmail": addDriverEmail
    };

    formData = JSON.stringify(formData);

    var request = $.ajax({
        url: "/addPetrosmartDriverApi",
        type: "POST",
        data: formData,
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            $("#addNewDriverBtn").removeAttr('disabled');

            // set value in storage to remind tabs to load this 
            sessionStorage.setItem('tabToGoto', 'driverTab');

            location.reload();

            $('#addDriversModal').modal('hide');
            displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

        } else {
            $("#addNewDriverBtn").removeAttr('disabled');
            console.log(data)
            displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log(textStatus);
        //show the error message
        $("#addNewDriverBtn").removeAttr('disabled');
        displayErrorMsgModal("Sorry, something went wrong");
    });


});


//DELETE Driver USER DATA
$(document).on('click', '[data-driver-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-driver-delete'));

    var formData = {
        "driver_id": jsonDetails.driver_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.name + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteDriverUserApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'driverTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// handle vehicles button
$(document).on('click', '[data-vehicle-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-vehicle-edit'));

    $('#displayVehicleName').html(toTitleCase(jsonDetails.name));
    $('#editVehicleName').val(jsonDetails.name);
    $('#editVehicleMake').val(jsonDetails.make);
    $('#editVehicleModel').val(jsonDetails.model);
    $('#editVehicleType').val(jsonDetails.veh_type);
    $('#editVehiclePlate').val(jsonDetails.number_plate);
    $('#editVehicleFuelType').val(jsonDetails.fuel_type);
    $('#editVehicleRegistrationDate').val(jsonDetails.reg_date);
    // $('#editVehicleDriverSelect').val(jsonDetails.driver_id);
    $('#editVehicleCompanySelect').val(jsonDetails.customer_id);
    $('#editVehicleCompanyBranchSelect').val(jsonDetails.branch_id);

    if (jsonDetails.drivers_selected == null || jsonDetails.drivers_selected == "" || jsonDetails.drivers_selected == undefined) {
        // do nothing
    } else {

        var hidValue = jsonDetails.drivers_selected;

        var selectedOptions = hidValue.split(",");
        for (var i in selectedOptions) {
            var optionVal = selectedOptions[i];
            $(".edit_driver_selected_picker").find("option[value=" + optionVal + "]").prop("selected", "selected");
        }
        $('.edit_driver_selected_picker').selectpicker('refresh')

    }

    $('#editVehicleCompanySelect').change();

    // $("#editVehicleBranchSelect option[value='"+jsonDetails.branch_id+"']").prop('selected', true);

    $('#editVehiclesModal').modal('show');

    /** ADD Vehicle API **/
    $("#editVehicleBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addVehicleName = $.trim($('#editVehicleName').val());
        var addVehicleMake = $.trim($('#editVehicleMake').val());
        var addVehicleModel = $.trim($('#editVehicleModel').val());
        var addVehicleType = $.trim($('#editVehicleType').val());
        var addVehiclePlate = $.trim($('#editVehiclePlate').val());
        var addVehicleFuelType = $.trim($('#editVehicleFuelType').val());
        var addVehicleRegistrationDate = $.trim($('#editVehicleRegistrationDate').val());
        var addVehicleDriverSelect = $.trim($('#editVehicleDriverSelect').val());
        var addVehicleBranchSelect = $.trim($('#editVehicleCompanyBranchSelect').val());
        var addVehicleCompanySelect = $.trim($('#editVehicleCompanySelect').val());

        if (addVehicleName == "" || addVehicleName == undefined) {
            displayErrorMsgModal("Vehicle Name must be filled"); //display Error message
            return false;
        } else if (addVehicleMake == "" || addVehicleMake == undefined) {
            displayErrorMsgModal("Make must be filled"); //display Error message
            return false;
        } else if (addVehicleModel == "" || addVehicleModel == undefined) {
            displayErrorMsgModal("Model must be filled"); //display Error message
            return false;
        } else if (addVehicleType == "" || addVehicleType == undefined) {
            displayErrorMsgModal("Model must be filled"); //display Error message
            return false;
        } else if (addVehicleType == "" || addVehicleType == undefined) {
            displayErrorMsgModal("Please select vehicle type"); //display Error message
            return false;
        } else if (addVehiclePlate == "" || addVehiclePlate == undefined) {
            displayErrorMsgModal("Please enter vehicle plate"); //display Error message
            return false;
        } else if (addVehicleFuelType == "" || addVehicleFuelType == undefined) {
            displayErrorMsgModal("Please select fuel type"); //display Error message
            return false;
        } else if (addVehicleDriverSelect == "" || addVehicleDriverSelect == undefined) {
            displayErrorMsgModal("Please select driver"); //display Error message
            return false;
        } else if (addVehicleBranchSelect == "" || addVehicleBranchSelect == undefined) {
            displayErrorMsgModal("Please select branch"); //display Error message
            return false;
        } else if (addVehicleCompanySelect == "" || addVehicleCompanySelect == undefined) {
            displayErrorMsgModal("Please select company"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = jsonDetails.veh_id;

            $("#editVehicleBtn").prop("disabled", true);

            var formData = {
                "user_id": user_id,
                "addVehicleName": addVehicleName,
                "addVehicleMake": addVehicleMake,
                "addVehicleModel": addVehicleModel,
                "addVehicleType": addVehicleType,
                "addVehiclePlate": addVehiclePlate,
                "addVehicleFuelType": addVehicleFuelType,
                "addVehicleRegistrationDate": addVehicleRegistrationDate,
                "addVehicleDriverSelect": addVehicleDriverSelect,
                "addVehicleBranchSelect": addVehicleBranchSelect,
                "addVehicleCompanySelect": addVehicleCompanySelect
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartVehicleApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editVehicleBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'vehicleTab');

                    // console.log(data);
                    location.reload();

                    $('#editVehiclesModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                } else {
                    $("#editVehicleBtn").removeAttr('disabled');
                    console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editVehicleBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });


});

//DELETE vehicle DATA
$(document).on('click', '[data-vehicle-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-vehicle-delete'));

    var formData = {
        "deleteType": "vehicle",
        "deleteId": jsonDetails.veh_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.name + "?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: true,
        confirmButtonText: "Yes"
    },

        function () {
            show_loader();

            var request = $.ajax({
                url: "/deleteGlobalApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'vehicleTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                } else {
                    hide_loader();
                    displayErrorMsg(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                displayErrorMsg("Sorry, something went wrong");
            });

        });

});

// Query admin forms Data
function getAdminUsersData() {
    var data_table = null;

    $('appCustomersDataTable').DataTable().destroy();

    data_table = $('#appCustomersDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getAdminUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'full_name', name: 'full_name' },
            { data: 'address', name: 'address' },
            { data: 'gps', name: 'gps' },
            { data: 'country_chosen', name: 'country_chosen' },
            { data: 'industry_chosen', name: 'industry_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-customer-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit customer'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-customer-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete customer'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query branch forms Data
function getBranchUsersData() {
    var data_table = null;

    $('branchesFormDataTable').DataTable().destroy();

    data_table = $('#branchesFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getBranchUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'gps', name: 'gps' },
            { data: 'contact1', name: 'contact1' },
            { data: 'contact2', name: 'contact2' },
            { data: 'country_chosen', name: 'country_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);


                    // lets check if rules have been set already to know which button to show
                    //var setRules = JSON.parse(data.set_rules);

                    //console.log(setRules)


                    var rules_action = "<a href='#' rel='tooltip' data-module-type='branch' data-driver-rules='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='set new rules'><i class='ti-plug'></i></a>";
                    var show_rules_action = "<a href='#' rel='tooltip' data-module-type='branch' data-driver-show-rules='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='update set rules'><i class='ti-credit-card'></i></a>";
                    var edit_action = "<a href='#' rel='tooltip' data-branch-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit branch'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-branch-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete branch'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {

                        // if null user has not set rules so hide the update button
                        if (data.set_rules == null) {
                            show_rules_action = ""
                        } else {
                            rules_action = ""
                        }
                        return rules_action + " " + show_rules_action + " " + edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query contact forms Data
function getContactUsersData() {
    var data_table = null;

    $('contactsFormDataTable').DataTable().destroy();

    data_table = $('#contactsFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getContactUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'email', name: 'email' },
            { data: 'tel', name: 'tel' },
            { data: 'mob', name: 'mob' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-contact-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit contact'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-contact-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete contact'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query fuel vouchers forms Data
function getFuelVouchersData() {
    var data_table = null;

    $('voucherFormDataTable').DataTable().destroy();

    data_table = $('#voucherFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFuelVouchersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'type_chosen', name: 'type_chosen' },
            { data: 'unit_amount', name: 'unit_amount' },
            { data: 'amount', name: 'amount' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'date_created', name: 'date_created' },
            { data: 'voucher_expiry_date', name: 'voucher_expiry_date' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    // var edit_action = "<a href='#' rel='tooltip' data-voucher-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit voucher'><i class='ti-pencil'></i></a>";
                    var edit_action = "";
                    var view_voucher_info = "<a href='#' rel='tooltip' data-voucher-info='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='view voucher info'><i class='ti-receipt'></i></a>";
                    // var delete_action = "<a href='#' rel='tooltip' data-voucher-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete voucher'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + view_voucher_info;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query fuel vouchers forms Data
function getDriverFuelVouchersData() {
    var data_table = null;

    $('driverVoucherFormDataTable').DataTable().destroy();

    data_table = $('#driverVoucherFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getDriverFuelVouchersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'type_chosen', name: 'type_chosen' },
            { data: 'amount', name: 'amount' },
            { data: 'balance', name: 'balance' },
            { data: 'usage_status', name: 'usage_status' },
            { data: 'date_created', name: 'date_created' },
            { data: 'voucher_expiry_date', name: 'voucher_expiry_date' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    //check if voucher status is deactivated
                    var voucherStatus = data.usage_status;
                   
                    var inactive_action = "<a href='#' rel='tooltip' data-voucher-inactive='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='make voucher inactive'><i class='ti-cut'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        if (voucherStatus.toUpperCase() == "DEACTIVATED") {
                            return "";
                        }else {
                            return inactive_action;
                        }
                        
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query contact forms Data
function getCountriesUsersData() {
    var data_table = null;

    $('countriesFormDataTable').DataTable().destroy();

    data_table = $('#countriesFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getCountriesUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'country', name: 'country' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-country-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit country'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-country-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete country'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query wallet forms Data
function getWalletUsersData() {
    var data_table = null;

    $('walletsFormDataTable').DataTable().destroy();

    data_table = $('#walletsFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getWalletUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'telco', name: 'telco' },
            { data: 'wallet_num', name: 'wallet_num' },
            { data: 'authorization_key', name: 'authorization_key' },
            { data: 'merchant_token', name: 'merchant_token' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-wallet-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit wallet'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-wallet-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete wallet'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query industries forms Data
function getIndustriesUsersData() {
    var data_table = null;

    $('industriesFormDataTable').DataTable().destroy();

    data_table = $('#industriesFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getIndustriesUsersDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'industry_name', name: 'industry_name' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-industry-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit industry'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-industry-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete industry'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }
                }
            },
        ]
    });

}

// Query payment forms Data
function getPaymentData() {
    var data_table = null;

    $('paymentsFormDataTable').DataTable().destroy();

    data_table = $('#paymentsFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getPaymentDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'station_chosen', name: 'station_chosen' },
            { data: 'payment_type', name: 'payment_type' },
            { data: 'voucher_chosen', name: 'voucher_chosen' },
            { data: 'company_amount', name: 'company_amount' },
            { data: 'voucher_type', name: 'voucher_type' },
            { data: 'voucher_amount', name: 'voucher_amount' },
            { data: 'date_chosen', name: 'date_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "";
                    // var edit_action = "<a href='#' rel='tooltip' data-payment-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit payment'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-payment-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete payment'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {
                        return edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query Driver forms Data
function getDriverData() {
    var data_table = null;

    $('driversFormDataTable').DataTable().destroy();

    data_table = $('#driversFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getDriverDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'dob', name: 'dob' },
            { data: 'email', name: 'email' },
            { data: 'mob', name: 'mob' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'device_chosen', name: 'device_chosen' },
            { data: 'vehicle_chosen', name: 'vehicle_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    // lets check if rules have been set already to know which button to show
                    //var setRules = JSON.parse(data.set_rules);

                    //console.log(setRules)


                    var rules_action = "<a href='#' rel='tooltip' data-module-type='driver' data-driver-rules='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='set new rules'><i class='ti-plug'></i></a>";
                    var show_rules_action = "<a href='#' rel='tooltip' data-module-type='driver' data-driver-show-rules='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='update set rules'><i class='ti-credit-card'></i></a>";
                    var edit_action = "<a href='#' rel='tooltip' data-driver-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit driver info'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-driver-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete driver info'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {

                        // if null user has not set rules so hide the update button
                        if (data.set_rules == null) {
                            show_rules_action = ""
                        } else {
                            rules_action = ""
                        }
                        return rules_action + " " + show_rules_action + " " + edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}

// Query Vehicle forms Data
function getVehicleData() {
    var data_table = null;

    $('vehiclesFormDataTable').DataTable().destroy();

    data_table = $('#vehiclesFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getVehicleDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'name', name: 'name' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'make', name: 'make' },
            { data: 'model', name: 'model' },
            { data: 'veh_type', name: 'veh_type' },
            { data: 'number_plate', name: 'number_plate' },
            { data: 'fuel_type', name: 'fuel_type' },
            { data: 'reg_date', name: 'reg_date' },
            { data: 'branch_chosen', name: 'branch_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    // lets check if rules have been set already to know which button to show
                    //var setRules = JSON.parse(data.set_rules);

                    //console.log(setRules)


                    var rules_action = "<a href='#' rel='tooltip' data-module-type='vehicle' data-driver-rules='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='set new rules'><i class='ti-plug'></i></a>";
                    var show_rules_action = "<a href='#' rel='tooltip' data-module-type='vehicle' data-driver-show-rules='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='update set rules'><i class='ti-credit-card'></i></a>";
                    var edit_action = "<a href='#' rel='tooltip' data-vehicle-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit driver'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-vehicle-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete driver'><i class='ti-trash'></i></a>";

                    if (userRoleSession == "ADMIN" || userRoleSession == "MANAGER") {

                        // if null user has not set rules so hide the update button
                        if (data.set_rules == null) {
                            show_rules_action = ""
                        } else {
                            rules_action = ""
                        }
                        return rules_action + " " + show_rules_action + " " + edit_action + " " + delete_action;
                    } else {
                        return "";
                    }

                }
            },
        ]
    });

}


// This will handle whether to show voucher code field or not for payment type
function getPaymentType(selectedValue) {
    var value = selectedValue.value.toUpperCase();

    if (value == "VOUCHER") {
        $("#voucherDiv").show("fast");
        $("#editVoucherDiv").show("fast");
        $("#companyAmountDiv").hide("fast");
        $("#multipleAmountDiv").hide("fast");
    } else {
        $("#voucherDiv").hide("fast");
        $("#editVoucherDiv").hide("fast");
        $("#companyAmountDiv").show("fast");
        $("#multipleAmountDiv").hide("fast");
    }
}

// This will make a call to get vouchers pertaining to a customer
function getCustomerVouchers(selectedValue) {
    var value = selectedValue.value;

    console.log("selected", value);

    if (value == "" || value == undefined || value == null) {
        // Clear the old data
        $('#addCustomerVoucherCode')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Voucher </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#editPaymentVoucherCode')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Voucher </option>')
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
            url: "/getCustomerVouchersApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                // Clear the old data
                $('#addCustomerVoucherCode')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Select Voucher </option>')
                    .val('')
                // .append('<option value="new">New Supplier</option>')
                // .val('new');

                var allData = data.RESPONSE_DATA;

                if (allData) {
                    // console.log("alldata", allData);

                    var select = $('#addCustomerVoucherCode');
                    var select2 = $('#editPaymentVoucherCode');


                    for (i = 0; i < allData.length; i++) {
                        mainData = allData[i];

                        select.append($("<option></option>").attr("value", mainData["fv_id"]).text(mainData["voucher_code"]));
                        select2.append($("<option></option>").attr("value", mainData["fv_id"]).text(mainData["voucher_code"]));

                    }

                    $('.select_voucher_picker').selectpicker();

                }

                displaySuccessMsgModal(data.RESPONSE_MESSAGE);


            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get customer vouchers");
        });

    }
}

// This will make a call to check the voucher type
function getVoucherUsageType(selectedValue) {
    var value = selectedValue.value;

    console.log("selected", value);

    if (value == "" || value == undefined || value == null) {
        return false;

    } else {
        show_modal_loader();
        //   lets get the voucher usage type

        var formData = {
            "voucherId": value
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/getVoucherUsageTypeApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                responseData = data.RESPONSE_DATA;
                displaySuccessMsgModal(data.RESPONSE_MESSAGE);

                // if type is single hide amount div
                if (responseData.type_chosen.toUpperCase() == "MULTIPLE USE") {
                    $("#multipleOnlyDiv").show("fast");
                } else {
                    $("#multipleOnlyDiv").hide("fast");
                }


                $("#addVoucherTypeCustomer").val(responseData.type_chosen);
                $("#voucherTypeIdentified").html(responseData.type_chosen);
                $("#totalVoucherAmount").html(responseData.amount);
                $("#totalVoucherBalance").html(responseData.amount - responseData.balance_left);
                $("#multipleAmountDiv").show("fast");

                //
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get voucher usage type");
        });

    }
}

// Date Picker Component
function dateOfBirthPicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#addDob span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#addDob').daterangepicker({
        parentEl: $('#addAttendantsModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#addDob').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}

// Date Picker Component
function addTimeOfDayToCard() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#addTimeOfDayToCard span').html(start.format('HH:mm') + ' - ' + end.format('HH:mm'));
    }

    $('#addTimeOfDayToCard').daterangepicker({
        parentEl: $('#DriverRulesModal'),
        timePicker: true,
        timePicker24Hour: true,
        startDate: start,
        endDate: end,
        locale: {
            format: 'HH:mm'
        },
        singleDatePicker: false,
        alwaysShowCalendars: false
    }, cb);

    cb(start, end);

}

// Date Picker Component
function addTimeOfDayToCardShow() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#addTimeOfDayToCardShow span').html(start.format('HH:mm') + ' - ' + end.format('HH:mm'));
    }

    $('#addTimeOfDayToCardShow').daterangepicker({
        parentEl: $('#showDriverRulesModal'),
        timePicker: true,
        timePicker24Hour: true,
        startDate: start,
        endDate: end,
        locale: {
            format: 'HH:mm'
        },
        singleDatePicker: false,
        alwaysShowCalendars: false
    }, cb);

    cb(start, end);

}

function editDateOfBirthPicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#editDob span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#editDob').daterangepicker({
        parentEl: $('#editAttendantsModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#editDob').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}

// Delivery Date Picker Component
function dateOfBirthDriverPicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#addDobDriver span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#addDobDriver').daterangepicker({
        parentEl: $('#addDriversModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#addDobDriver').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}

// Registration Date Picker Component
function registrationDatePicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#addVehicleRegistrationDate span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#addVehicleRegistrationDate').daterangepicker({
        parentEl: $('#addVehiclesModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#addVehicleRegistrationDate').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}

// Registration Date Picker Component
function editregistrationDatePicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#editVehicleRegistrationDate span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#editVehicleRegistrationDate').daterangepicker({
        parentEl: $('#editVehiclesModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment()],
            'Tomorrow': [moment().startOf('day').add(1, 'days'), moment().add(1, 'days')],
            'Next Week': [moment().startOf('day').add(6, 'days'), moment()],
            'Next Month': [moment().startOf('day').add(29, 'days'), moment()],
            'This Month': [moment().startOf('day').startOf('month'), moment().endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#editVehicleRegistrationDate').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}

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


// Date Picker Component
function voucherExpiryDatePicker() {

    var start = moment().startOf('day');
    var end = moment().endOf('day');

    function cb(start, end) {
        $('#voucherExpiryDate span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }

    $('#voucherExpiryDate').daterangepicker({
        parentEl: $('#addVoucherModal'),
        timePicker: false,
        timePicker24Hour: false,
        startDate: start,
        endDate: end,
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true
    }, cb);

    cb(start, end);

    // on select 
    $('#voucherExpiryDate').on('apply.daterangepicker', function (ev, picker) {

        allStartDate = picker.startDate.format('YYYY-MM-DD');
        allEndDate = picker.endDate.format('YYYY-MM-DD');

        //  do something, like logging an input
        console.log("all Start date");
        console.log(allStartDate);

        console.log('allEndDate');
        console.log(allEndDate);

    });

}
