var addFuelStationWalletApi = "/addFuelStationWalletApi";
var userRoleSession = sessionStorage.getItem("userRoleSession");

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

        getStoredItem();

    }, 1000);

    setTimeout(function () { getFuelStationsData(); }, 2000);
    setTimeout(function () { getClusteredStationsData(); }, 2500);
    setTimeout(function () { getFuelAttendantsData(); }, 3000);
    setTimeout(function () { getWalletUsersData(); }, 3500);
    setTimeout(function () { getFuelPosData(); }, 4000);
    setTimeout(function () { getOmcData(); }, 4500);
    setTimeout(function () { getPaymentData(); }, 5000);
    setTimeout(function () { getPurchaseData(); }, 5500);

    setTimeout(function () { dateOfBirthPicker(); }, 5600);
    setTimeout(function () { editDateOfBirthPicker(); }, 5700);
    setTimeout(function () { dateOfBirthDriverPicker(); }, 5800);
    setTimeout(function () { registrationDatePicker(); }, 5900);
    setTimeout(function () { editregistrationDatePicker(); }, 6000);
    setTimeout(function () { getCountriesArray(); }, 6500);
    setTimeout(function () { getOmcArray(); }, 7000);
    setTimeout(function () { getClusteredArray(); }, 7500);
    setTimeout(function () { getPosArray(); }, 8000);
    setTimeout(function () { getFuelStationsArray(); }, 8500);
    setTimeout(function () { getCustomersArray(); }, 9000);
    setTimeout(function () { getAllBranchesArray(); }, 9500);
    setTimeout(function () { getAllDevicesArray(); }, 10000);
    setTimeout(function () { getAllDriversArray(); }, 10500);
   
    setTimeout(function () {
        hide_loader();
        hide_modal_loader();
    }, 11000);
});


/** ADD FUELSTATION API **/

$("#addFuelStationBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var name = $.trim($('#addName').val());
    var address = $.trim($('#addAddress').val());
    var gps = $.trim($('#addGps').val());
    var gpsRadius = $.trim($('#addGpsRadius').val());
    var country = $.trim($('#addCountry').val());
    var selectedOmc = $.trim($('#addStationOMC').val());
    var addStationPos = $.trim($('#addStationPos').val());

    if (name == "" || name == undefined) {
        displayErrorMsgModal("Name must be filled"); //display Error message
        return false;
    }
    else if (address == "" || address == undefined) {
        displayErrorMsgModal("Address must be filled"); //display Error message
        return false;
    }
    else if (gps == "" || gps == undefined || gps == NaN) {
        displayErrorMsgModal("GPS must be filled"); //display Error message
        return false;
    }
    else if (gpsRadius == "" || gpsRadius == undefined || gpsRadius == NaN) {
        displayErrorMsgModal("GPS Radius must be filled"); //display Error message
        return false;
    }
    else if (selectedOmc == "" || selectedOmc == undefined) {
        displayErrorMsgModal("OMC must be selected"); //display Error message
        return false;
    }
    else if (country == "" || country == undefined) {
        displayErrorMsgModal("Country must be filled"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addFuelStationBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "name": name,
            "address": address,
            "gps": gps,
            "gpsRadius": gpsRadius,
            "selectedOmc": selectedOmc,
            "addStationPos": addStationPos,
            "country": country
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartFuelStationApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addFuelStationBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'fuelStationTab');

                // console.log(data);
                location.reload();

                $('#addFuelStationModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addFuelStationBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addFuelStationBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


/** ADD CLUSTERED STATION API **/

$("#addClusteredFuelStationBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var name = $.trim($('#addClusterName').val());
    var stations = $.trim($('#addClusteredFuelStations').val());

    if (name == "" || name == undefined) {
        displayErrorMsgModal("Name must be filled"); //display Error message
        return false;
    }
    else if (stations == "" || stations == undefined) {
        displayErrorMsgModal("more than one station must be selected"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addClusteredFuelStationBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "name": name,
            "stations": stations
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartClusteredStationApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addClusteredFuelStationBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'clusteredTab');

                // console.log(data);
                location.reload();

                $('#addClusteredStationModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addClusteredFuelStationBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addClusteredFuelStationBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


/** ADD FUEL ATTENDANTS API **/

$("#addFuelAttendantsBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var name = $.trim($('#addAttendantName').val());
    var address = $.trim($('#addAttendantAddress').val());
    var dob = $.trim($('#addDob').val());
    var email = $.trim($('#addAttendantEmail').val());
    var tel = $.trim($('#addAttendantTel').val());
    var mob = $.trim($('#addAttendantMob').val());
    var pin = $.trim($('#addAttendantPin').val());
    var fuelStation = $.trim($('#addFuelStations').val());
    var selectedPos = $.trim($('#addSelectedPos').val());

    if (name == "" || name == undefined) {
        displayErrorMsgModal("Name must be filled"); //display Error message
        return false;
    }
    else if (address == "" || address == undefined) {
        displayErrorMsgModal("Address must be filled"); //display Error message
        return false;
    }
    else if (dob == "" || dob == undefined) {
        displayErrorMsgModal("Select Date of birth"); //display Error message
        return false;
    }
    else if (email == "" || email == undefined) {
        displayErrorMsgModal("Email must be filled"); //display Error message
        return false;
    }
    else if (tel == "" || tel == undefined || tel == NaN) {
        displayErrorMsgModal("Telephone must be filled"); //display Error message
        return false;
    }
    else if (mob == "" || mob == undefined || mob == NaN) {
        displayErrorMsgModal("Telephone must be filled"); //display Error message
        return false;
    }
    else if (pin == "" || pin == undefined || pin == NaN) {
        displayErrorMsgModal("Telephone must be filled"); //display Error message
        return false;
    }
    else if (selectedPos == "" || selectedPos == undefined) {
        displayErrorMsgModal("POS must be selected"); //display Error message
        return false;
    }
    else if (fuelStation == "" || fuelStation == undefined) {
        displayErrorMsgModal("Telephone must be filled"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addFuelAttendantsBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "name": name,
            "address": address,
            "dob": dob,
            "email": email,
            "tel": tel,
            "mob": mob,
            "pin": pin,
            "selectedPos": selectedPos,
            "fuelStation": fuelStation
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartFuelAttendantsApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addFuelAttendantsBtn").removeAttr('disabled');
                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'attendantTab');

                // console.log(data);
                location.reload();

                $('#addFuelAttendantsModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addFuelAttendantsBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addFuelAttendantsBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});


/** ADD WALLET API **/
$("#addWalletBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addStationWallet = $.trim($('#addStationWallet').val());
    var addTelco = $.trim($('#addTelco').val());
    var addWalletNum = $.trim($('#addWalletNum').val());

    if (addStationWallet == "" || addStationWallet == undefined) {
        displayErrorMsgModal("Please select a fuel station"); //display Error message
        return false;
    }

    else if (addTelco == "" || addTelco == undefined) {
        displayErrorMsgModal("Please select a Telco"); //display Error message
        return false;
    } else if (addWalletNum == "" || addWalletNum == NaN || addWalletNum == undefined) {
        displayErrorMsgModal("Wallet Number must be filled"); //display Error message
        return false;
    } else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        // block the button from being clicked
        $("#addWalletBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addStationWallet": addStationWallet,
            "addTelco": addTelco,
            "addWalletNum": addWalletNum
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: addFuelStationWalletApi,
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                document.getElementById("addWalletForm").reset();
                $("#addWalletBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'walletTab2');

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


/** ADD FUEL POS API **/
$("#addPosBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    // var addFuelStationsPos = $.trim($('#addFuelStationsPos').val());
    var addPosMake = $.trim($('#addPosMake').val());
    var addPosModel = $.trim($('#addPosModel').val());
    var addPosSerial = $.trim($('#addPosSerial').val());


    // if (addFuelStationsPos == "" || addFuelStationsPos == undefined) {
    //     displayErrorMsgModal("Please select fuel station"); //display Error message
    //     return false;
    // }
    if (addPosMake == "" || addPosMake == undefined) {
        displayErrorMsgModal("Make must be filled"); //display Error message
        return false;
    }
    else if (addPosModel == "" || addPosModel == undefined) {
        displayErrorMsgModal("Model must be filled"); //display Error message
        return false;
    }
    else if (addPosSerial == "" || addPosSerial == undefined) {
        displayErrorMsgModal("Serial number must be filled"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addPosBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            // "addFuelStationsPos": addFuelStationsPos,
            "addPosMake": addPosMake,
            "addPosModel": addPosModel,
            "addPosSerial": addPosSerial
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartFuelPosApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addPosBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'posTab');

                // console.log(data);
                location.reload();

                $('#addPosModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addPosBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addPosBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

/** ADD OMC API **/
$("#addOmcBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addOmcName = $.trim($('#addOmcName').val());
    var addOmcAddress = $.trim($('#addOmcAddress').val());
    var addOmcCountry = $.trim($('#addOmcCountry').val());


    if (addOmcName == "" || addOmcName == undefined) {
        displayErrorMsgModal("Please enter OMC name"); //display Error message
        return false;
    }
    else if (addOmcAddress == "" || addOmcAddress == undefined) {
        displayErrorMsgModal("Address must be filled"); //display Error message
        return false;
    }
    else if (addOmcCountry == "" || addOmcCountry == undefined) {
        displayErrorMsgModal("Please select country"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addOmcBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addOmcName": addOmcName,
            "addOmcAddress": addOmcAddress,
            "addOmcCountry": addOmcCountry
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartOmcApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addOmcBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'omcTab');

                // console.log(data);
                location.reload();

                $('#addOmcModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addOmcBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addOmcBtn").removeAttr('disabled');
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
    var addVoucherType = $.trim($('#addVoucherType').val());


    if (addPaymentCustomer == "" || addPaymentCustomer == undefined) {
        displayErrorMsgModal("Please select a customer"); //display Error message
        return false;
    }
    else if (addFuelStationsPayment == "" || addFuelStationsPayment == undefined) {
        displayErrorMsgModal("Please select filling station"); //display Error message
        return false;
    }
    else if (addPaymentType == "" || addPaymentType == undefined) {
        displayErrorMsgModal("Please select payment type"); //display Error message
        return false;
    }
    else if (addPaymentDriver == "" || addPaymentDriver == undefined) {
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
                sessionStorage.setItem('tabToGoto', 'paymentTab');

                // console.log(data);
                location.reload();

                $('#addPaymentModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }
            else if (data.RESPONSE_CODE == "204") {
                $("#addPaymentBtn").removeAttr('disabled');

                displayErrorMsgModal(data.RESPONSE_MESSAGE);
            }

            else {
                $("#addPaymentBtn").removeAttr('disabled');
                // console.log(data)
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
            //show the error message
            $("#addPaymentBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
            // }
        });

    }

});

/** ADD Purchase API **/
$("#addPurchaseBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var addPurchaseCustomer = $.trim($('#addPurchaseCustomer').val());
    var addFuelStationsPurchase = $.trim($('#addFuelStationsPurchase').val());
    var addPurchaseAmount = $.trim($('#addPurchaseAmount').val());
    var addPurchaseItems = $.trim($('#addPurchaseItems').val());
    var addPurchaseDriver = $.trim($('#addPurchaseDriver').val());
    var addPurchaseVehicle = $.trim($('#addPurchaseVehicle').val());

    if (addPurchaseCustomer == "" || addPurchaseCustomer == undefined) {
        displayErrorMsgModal("Please select a customer"); //display Error message
        return false;
    }
    else if (addFuelStationsPurchase == "" || addFuelStationsPurchase == undefined) {
        displayErrorMsgModal("Please select filling station"); //display Error message
        return false;
    }
    else if (addPurchaseAmount == "" || addPurchaseAmount == undefined) {
        displayErrorMsgModal("Please enter amount"); //display Error message
        return false;
    }
    else if (addPurchaseItems == "" || addPurchaseItems == undefined) {
        displayErrorMsgModal("Please enter purchase items"); //display Error message
        return false;
    }
    else if (addPurchaseDriver == "" || addPurchaseDriver == undefined) {
        displayErrorMsgModal("Please select a driver"); //display Error message
        return false;
    }
    else if (addPurchaseVehicle == "" || addPurchaseVehicle == undefined) {
        displayErrorMsgModal("Please select a driver vehicle"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addPurchaseBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "addPurchaseCustomer": addPurchaseCustomer,
            "addFuelStationsPurchase": addFuelStationsPurchase,
            "addPurchaseAmount": addPurchaseAmount,
            "addPurchaseItems": addPurchaseItems,
            "addPurchaseDriver": addPurchaseDriver,
            "addPurchaseVehicle": addPurchaseVehicle
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartPurchaseApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addPurchaseBtn").removeAttr('disabled');

                // set value in storage to remind tabs to load this 
                sessionStorage.setItem('tabToGoto', 'purchaseTab');

                // console.log(data);
                location.reload();

                $('#addPurchaseModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addPurchaseBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addPurchaseBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

// /** ADD Vehicle API **/
// $("#addVehicleBtn").click(function (e) {
//     e.preventDefault();
//     show_modal_loader();

//     var addVehicleName = $.trim($('#addVehicleName').val());
//     var addVehicleMake = $.trim($('#addVehicleMake').val());
//     var addVehicleModel = $.trim($('#addVehicleModel').val());
//     var addVehicleType = $.trim($('#addVehicleType').val());
//     var addVehiclePlate = $.trim($('#addVehiclePlate').val());
//     var addVehicleFuelType = $.trim($('#addVehicleFuelType').val());
//     var addVehicleRegistrationDate = $.trim($('#addVehicleRegistrationDate').val());
//     var addVehicleDriverSelect = $.trim($('#addVehicleDriverSelect').val());
//     var addVehicleBranchSelect = $.trim($('#addVehicleBranchSelect').val());

//     if (addVehicleName == "" || addVehicleName == undefined) {
//         displayErrorMsgModal("Vehicle Name must be filled"); //display Error message
//         return false;
//     }
//     else if (addVehicleMake == "" || addVehicleMake == undefined) {
//         displayErrorMsgModal("Make must be filled"); //display Error message
//         return false;
//     }
//     else if (addVehicleModel == "" || addVehicleModel == undefined) {
//         displayErrorMsgModal("Model must be filled"); //display Error message
//         return false;
//     }
//     else if (addVehicleType == "" || addVehicleType == undefined) {
//         displayErrorMsgModal("Model must be filled"); //display Error message
//         return false;
//     }
//     else if (addVehicleType == "" || addVehicleType == undefined) {
//         displayErrorMsgModal("Please select vehicle type"); //display Error message
//         return false;
//     }
//     else if (addVehiclePlate == "" || addVehiclePlate == undefined) {
//         displayErrorMsgModal("Please enter vehicle plate"); //display Error message
//         return false;
//     }
//     else if (addVehicleFuelType == "" || addVehicleFuelType == undefined) {
//         displayErrorMsgModal("Please select fuel type"); //display Error message
//         return false;
//     }
//     else if (addVehicleDriverSelect == "" || addVehicleDriverSelect == undefined) {
//         displayErrorMsgModal("Please select driver"); //display Error message
//         return false;
//     }
//     else if (addVehicleBranchSelect == "" || addVehicleBranchSelect == undefined) {
//         displayErrorMsgModal("Please select branch"); //display Error message
//         return false;
//     }

//     else {

//         // call userRandomString() to get a random id for the user
//         user_id = userRandomString();

//         $("#addVehicleBtn").prop("disabled", true);

//         var formData = {
//             "user_id": user_id,
//             "addVehicleName": addVehicleName,
//             "addVehicleMake": addVehicleMake,
//             "addVehicleModel": addVehicleModel,
//             "addVehicleType": addVehicleType,
//             "addVehiclePlate": addVehiclePlate,
//             "addVehicleFuelType": addVehicleFuelType,
//             "addVehicleRegistrationDate": addVehicleRegistrationDate,
//             "addVehicleDriverSelect": addVehicleDriverSelect,
//             "addVehicleBranchSelect": addVehicleBranchSelect
//         };

//         formData = JSON.stringify(formData);

//         var request = $.ajax({
//             url: "/addPetrosmartVehicleApi",
//             type: "POST",
//             data: formData,
//             contentType: "application/json"
//         });

//         request.done(function (data) {
//             if (data.RESPONSE_CODE == "200") {
//                 $("#addVehicleBtn").removeAttr('disabled');

//                 // set value in storage to remind tabs to load this 
//                 sessionStorage.setItem('tabToGoto', 'vehicleTab');

// console.log(data);
//                 location.reload();

//                 $('#addVehiclesModal').modal('hide');
//                 displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
//             }

//             else {
//                 $("#addVehicleBtn").removeAttr('disabled');
//                 console.log(data)
//                 displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
//             }
//         });

//         // Handle when it failed to connect
//         request.fail(function (jqXHR, textStatus) {
//             console.log(textStatus);
//             //show the error message
//             $("#addVehicleBtn").removeAttr('disabled');
//             displayErrorMsgModal("Sorry, something went wrong");
//         });

//     }

// });



// EDIT AND DELETE STARTS HERE

// handle stations button
$(document).on('click', '[data-cluster-station-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-cluster-station-edit'));

    $('#displayClusterName').html(toTitleCase(jsonDetails.name));
    $('#editClusterName').val(jsonDetails.name);


    // lets display the selected pos since it more than one

    var hidValue = jsonDetails.fuel_stations_list;

    var selectedOptions = hidValue.split(",");
    for (var i in selectedOptions) {
        var optionVal = selectedOptions[i];
        $(".select_clustered_edit_fuel_stations").find("option[value=" + optionVal + "]").prop("selected", "selected");
    }
    $('.select_clustered_edit_fuel_stations').selectpicker('refresh')


    $('#editClusteredStationModal').modal('show');

    /** EDIT CLUSTERED FUELSTATION API **/

    $("#editClusteredFuelStationBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var user_id;
        var name = $.trim($('#editClusterName').val());
        var stations = $.trim($('#editClusteredFuelStations').val());

        if (name == "" || name == undefined) {
            displayErrorMsgModal("Name must be filled"); //display Error message
            return false;
        }
        else if (stations == "" || stations == undefined) {
            displayErrorMsgModal("more than one station must be selected"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editClusteredFuelStationBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.cluster_id,
                "name": name,
                "stations": stations
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartClusteredStationApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editClusteredFuelStationBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'clusteredTab');

                    // console.log(data);
                    location.reload();

                    $('#editClusteredStationModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editClusteredFuelStationBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editClusteredFuelStationBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE STATION DATA
$(document).on('click', '[data-cluster-station-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-cluster-station-delete'));

    var formData = {
        "deleteType": "cluster",
        "deleteId": jsonDetails.cluster_id
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
                    sessionStorage.setItem('tabToGoto', 'clusteredTab');
                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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


// handle stations button
$(document).on('click', '[data-station-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-station-edit'));

    $('#displayStationName').html(toTitleCase(jsonDetails.name));
    $('#editName').val(jsonDetails.name);
    $('#editAddress').val(jsonDetails.address);
    $('#editGps').val(jsonDetails.gps);
    $('#editGpsRadius').val(jsonDetails.gps_radius);
    $('#editCountry').val(jsonDetails.omccountry_id);
    $('#editFuelStationOmc').val(jsonDetails.linked_omc);

    // lets display the selected pos since it more than one

    var hidValue = jsonDetails.pos_selected;

    var selectedOptions = hidValue.split(",");
    for (var i in selectedOptions) {
        var optionVal = selectedOptions[i];
        $(".select_picker_station_pos_edit").find("option[value=" + optionVal + "]").prop("selected", "selected");
    }
    $('.select_picker_station_pos_edit').selectpicker('refresh')




    // $('#editStationPos').text(jsonDetails.pos_selected).selectPicker('refresh');

    $('#editFuelStationModal').modal('show');

    /** EDIT FUELSTATION API **/

    $("#editFuelStationBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var user_id;
        var name = $.trim($('#editName').val());
        var address = $.trim($('#editAddress').val());
        var gps = $.trim($('#editGps').val());
        var gpsRadius = $.trim($('#editGpsRadius').val());
        var country = $.trim($('#editCountry').val());
        var selectedOmc = $.trim($('#editFuelStationOmc').val());
        var addStationPos = $.trim($('#editStationPos').val());

        if (name == "" || name == undefined) {
            displayErrorMsgModal("Name must be filled"); //display Error message
            return false;
        }
        else if (address == "" || address == undefined) {
            displayErrorMsgModal("Address must be filled"); //display Error message
            return false;
        }
        else if (gps == "" || gps == undefined || gps == NaN) {
            displayErrorMsgModal("GPS must be filled"); //display Error message
            return false;
        }
        else if (gpsRadius == "" || gpsRadius == undefined || gpsRadius == NaN) {
            displayErrorMsgModal("GPS Radius must be filled"); //display Error message
            return false;
        }
        else if (selectedOmc == "" || selectedOmc == undefined) {
            displayErrorMsgModal("OMC must be selected"); //display Error message
            return false;
        }
        else if (country == "" || country == undefined) {
            displayErrorMsgModal("Country must be filled"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editFuelStationBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.station_id,
                "name": name,
                "address": address,
                "gps": gps,
                "gpsRadius": gpsRadius,
                "selectedOmc": selectedOmc,
                "addStationPos": addStationPos,
                "country": country
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartFuelStationApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editFuelStationBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'fuelStationTab');

                    // console.log(data);
                    location.reload();

                    $('#editFuelStationModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editFuelStationBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editFuelStationBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE STATION DATA
$(document).on('click', '[data-station-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-station-delete'));

    var formData = {
        "deleteType": "station",
        "deleteId": jsonDetails.station_id
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
                    sessionStorage.setItem('tabToGoto', 'fuelStationTab');
                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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

// handle attendant button
$(document).on('click', '[data-attendant-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-attendant-edit'));

    $('#displayAttendantName').html(toTitleCase(jsonDetails.name));
    $('#editAttendantName').val(jsonDetails.name);
    $('#editAttendantAddress').val(jsonDetails.address);
    $('#editDob').val(jsonDetails.dob);
    $('#editAttendantEmail').val(jsonDetails.email);
    $('#editAttendantTel').val(jsonDetails.tel);
    $('#editAttendantMob').val(jsonDetails.mob);
    $('#editAttendantPin').val(jsonDetails.pin);
    $('#editFuelStations').val(jsonDetails.station_id);
    $('#editSelectedPos').val(jsonDetails.linked_pos);

    $('#editAttendantsModal').modal('show');

    /** EDIT FUEL ATTENDANTS API **/

    $("#editFuelAttendantsBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var name = $.trim($('#editAttendantName').val());
        var address = $.trim($('#editAttendantAddress').val());
        var dob = $.trim($('#editDob').val());
        var email = $.trim($('#editAttendantEmail').val());
        var tel = $.trim($('#editAttendantTel').val());
        var mob = $.trim($('#editAttendantMob').val());
        var pin = $.trim($('#editAttendantPin').val());
        var fuelStation = $.trim($('#editFuelStations').val());
        var selectedPos = $.trim($('#editSelectedPos').val());

        if (name == "" || name == undefined) {
            displayErrorMsgModal("Name must be filled"); //display Error message
            return false;
        }
        else if (address == "" || address == undefined) {
            displayErrorMsgModal("Address must be filled"); //display Error message
            return false;
        }
        else if (dob == "" || dob == undefined) {
            displayErrorMsgModal("Select Date of birth"); //display Error message
            return false;
        }
        else if (email == "" || email == undefined) {
            displayErrorMsgModal("Email must be filled"); //display Error message
            return false;
        }
        else if (tel == "" || tel == undefined || tel == NaN) {
            displayErrorMsgModal("Telephone must be filled"); //display Error message
            return false;
        }
        else if (mob == "" || mob == undefined || mob == NaN) {
            displayErrorMsgModal("Telephone must be filled"); //display Error message
            return false;
        }
        else if (pin == "" || pin == undefined || pin == NaN) {
            displayErrorMsgModal("Telephone must be filled"); //display Error message
            return false;
        }
        else if (selectedPos == "" || selectedPos == undefined) {
            displayErrorMsgModal("POS must be selected"); //display Error message
            return false;
        }
        else if (fuelStation == "" || fuelStation == undefined) {
            displayErrorMsgModal("Telephone must be filled"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editFuelAttendantsBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.att_id,
                "name": name,
                "address": address,
                "dob": dob,
                "email": email,
                "tel": tel,
                "mob": mob,
                "pin": pin,
                "selectedPos": selectedPos,
                "fuelStation": fuelStation
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartFuelAttendantsApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editFuelAttendantsBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'attendantTab');

                    // console.log(data);
                    location.reload();

                    $('#editAttendantsModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editFuelAttendantsBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editFuelAttendantsBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});

//DELETE ATTENDANT DATA
$(document).on('click', '[data-attendant-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-attendant-delete'));

    var formData = {
        "deleteType": "attendant",
        "deleteId": jsonDetails.att_id
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
                    sessionStorage.setItem('tabToGoto', 'attendantTab');
                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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

// // handle voucher button
// $(document).on('click', '[data-voucher-edit]', function (e) {

//     var jsonDetails = JSON.parse($(this).attr('data-voucher-edit'));

//     $('#displayVoucherName').html(toTitleCase(jsonDetails.customer_chosen));
//     $('#editCustomerContact').val(jsonDetails.customer);
//     $('#editVoucherType').val(jsonDetails.voucher_type);
//     $('#editVoucherAmount').val(jsonDetails.amount);

//     $('#editVoucherModal').modal('show');

//     /** EDIT FUEL VOUCHERS API **/

//     $("#editVoucherBtn").click(function (e) {
//         e.preventDefault();
//         show_modal_loader();

//         var addCustomerContact = $.trim($('#editCustomerContact').val());
//         var addVoucherType = $.trim($('#editVoucherType').val());
//         var addVoucherAmount = $.trim($('#editVoucherAmount').val());


//         if (addCustomerContact == "" || addCustomerContact == undefined) {
//             displayErrorMsgModal("Please Select Company"); //display Error message
//             return false;
//         }
//         else if (addVoucherType == "" || addVoucherType == undefined) {
//             displayErrorMsgModal("Please select voucher type"); //display Error message
//             return false;
//         }
//         else if (addVoucherAmount == "" || addVoucherAmount == undefined) {
//             displayErrorMsgModal("Please enter voucher amount"); //display Error message
//             return false;
//         }

//         else {

//             // call userRandomString() to get a random id for the user
//             user_id = userRandomString();
//             addVoucherCode = itemRandomString();

//             $("#editVoucherBtn").prop("disabled", true);

//             var formData = {
//                 "user_id": jsonDetails.fv_id,
//                 "addVoucherCode": addVoucherCode,
//                 "addCustomerContact": addCustomerContact,
//                 "addVoucherType": addVoucherType,
//                 "addVoucherAmount": addVoucherAmount
//             };

//             formData = JSON.stringify(formData);

//             var request = $.ajax({
//                 url: "/addPetrosmartFuelVouchersApi",
//                 type: "POST",
//                 data: formData,
//                 contentType: "application/json"
//             });

//             request.done(function (data) {
//                 if (data.RESPONSE_CODE == "200") {
//                     $("#editVoucherBtn").removeAttr('disabled');

// console.log(data);
//                     location.reload();

//                     $('#editVoucherModal').modal('hide');
//                     displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
//                 }

//                 else {
//                     $("#editVoucherBtn").removeAttr('disabled');
//                     console.log(data)
//                     displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
//                 }
//             });

//             // Handle when it failed to connect
//             request.fail(function (jqXHR, textStatus) {
//                 console.log(textStatus);
//                 //show the error message
//                 $("#editVoucherBtn").removeAttr('disabled');
//                 displayErrorMsgModal("Sorry, something went wrong");
//             });

//         }

//     });




// });

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
//                     location.reload();
//                     displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

//                 }

//                 else {
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



// handle wallets button
$(document).on('click', '[data-wallet-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-wallet-edit'));

    $('#displayWalletName').html(toTitleCase(jsonDetails.wallet_num));
    $('#editCompanyWallet').val(jsonDetails.customer_selected);
    $('#editWalletBranchSelect').val(jsonDetails.custb_id);
    $('#editTelco').val(jsonDetails.telco);
    $('#editWalletNum').val(jsonDetails.wallet_num);

    $('#editWalletModal').modal('show');

    /** EDIT WALLET API **/
    $("#editWalletBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addStationWallet = $.trim($('#editStationWallet').val());
        var addTelco = $.trim($('#editTelco').val());
        var addWalletNum = $.trim($('#editWalletNum').val());

        if (addStationWallet == "" || addStationWallet == undefined) {
            displayErrorMsgModal("Please select a fuel station"); //display Error message
            return false;
        } else if (addTelco == "" || addTelco == undefined) {
            displayErrorMsgModal("Please select a Telco"); //display Error message
            return false;
        } else if (addWalletNum == "" || addWalletNum == NaN || addWalletNum == undefined) {
            displayErrorMsgModal("Wallet Number must be filled"); //display Error message
            return false;
        } else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            // block the button from being clicked
            $("#editWalletBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.custw_id,
                "addStationWallet": addStationWallet,
                "addTelco": addTelco,
                "addWalletNum": addWalletNum
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: addFuelStationWalletApi,
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    document.getElementById("addWalletForm").reset();
                    $("#editWalletBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'walletTab2');

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
        "deleteType": "walletFuelStation",
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
                    sessionStorage.setItem('tabToGoto', 'walletTab2');

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

// handle pos button
$(document).on('click', '[data-pos-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-pos-edit'));

    $('#displayPosName').html(toTitleCase(jsonDetails.make));
    // $('#editFuelStationsPos').val(jsonDetails.station_id);
    $('#editPosMake').val(jsonDetails.make);
    $('#editPosModel').val(jsonDetails.model);
    $('#editPosSerial').val(jsonDetails.serial_no);


    $('#editPosModal').modal('show');


    /** EDIT FUEL POS API **/
    $("#editPosBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        // var addFuelStationsPos = $.trim($('#editFuelStationsPos').val());
        var addPosMake = $.trim($('#editPosMake').val());
        var addPosModel = $.trim($('#editPosModel').val());
        var addPosSerial = $.trim($('#editPosSerial').val());


        // if (addFuelStationsPos == "" || addFuelStationsPos == undefined) {
        //     displayErrorMsgModal("Please select fuel station"); //display Error message
        //     return false;
        // }
        if (addPosMake == "" || addPosMake == undefined) {
            displayErrorMsgModal("Make must be filled"); //display Error message
            return false;
        }
        else if (addPosModel == "" || addPosModel == undefined) {
            displayErrorMsgModal("Model must be filled"); //display Error message
            return false;
        }
        else if (addPosSerial == "" || addPosSerial == undefined) {
            displayErrorMsgModal("Serial number must be filled"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editPosBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.pos_id,
                // "addFuelStationsPos": addFuelStationsPos,
                "addPosMake": addPosMake,
                "addPosModel": addPosModel,
                "addPosSerial": addPosSerial
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartFuelPosApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editPosBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'posTab');

                    // console.log(data);
                    location.reload();

                    $('#editPosModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editPosBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editPosBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE POS DATA
$(document).on('click', '[data-pos-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-pos-delete'));

    var formData = {
        "deleteType": "pos",
        "deleteId": jsonDetails.pos_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.make + "?",
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
                    sessionStorage.setItem('tabToGoto', 'posTab');
                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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

// handle omc button
$(document).on('click', '[data-omc-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-omc-edit'));

    $('#displayOmcName').html(toTitleCase(jsonDetails.name));
    $('#editOmcName').val(jsonDetails.name);
    $('#editOmcAddress').val(jsonDetails.address);
    $('#editOmcCountry').val(jsonDetails.country);

    $('#editOmcModal').modal('show');

    /** Edit OMC API **/
    $("#editOmcBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addOmcName = $.trim($('#editOmcName').val());
        var addOmcAddress = $.trim($('#editOmcAddress').val());
        var addOmcCountry = $.trim($('#editOmcCountry').val());


        if (addOmcName == "" || addOmcName == undefined) {
            displayErrorMsgModal("Please enter OMC name"); //display Error message
            return false;
        }
        else if (addOmcAddress == "" || addOmcAddress == undefined) {
            displayErrorMsgModal("Address must be filled"); //display Error message
            return false;
        }
        else if (addOmcCountry == "" || addOmcCountry == undefined) {
            displayErrorMsgModal("Please select country"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editOmcBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.omc_id,
                "addOmcName": addOmcName,
                "addOmcAddress": addOmcAddress,
                "addOmcCountry": addOmcCountry
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartOmcApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editOmcBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'omcTab');

                    // console.log(data);
                    location.reload();

                    $('#editOmcModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editOmcBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editOmcBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE OMC DATA
$(document).on('click', '[data-omc-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-omc-delete'));

    var formData = {
        "deleteType": "omc",
        "deleteId": jsonDetails.omc_id
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
                    sessionStorage.setItem('tabToGoto', 'omcTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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
        }
        else if (addFuelStationsPayment == "" || addFuelStationsPayment == undefined) {
            displayErrorMsgModal("Please select filling station"); //display Error message
            return false;
        }
        else if (addPaymentType == "" || addPaymentType == undefined) {
            displayErrorMsgModal("Please select payment type"); //display Error message
            return false;
        }
        else if (addPaymentDriver == "" || addPaymentDriver == undefined) {
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
                    sessionStorage.setItem('tabToGoto', 'paymentTab');

                    // console.log(data);
                    location.reload();

                    $('#editPaymentModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editPaymentBtn").removeAttr('disabled');
                    // console.log(data)
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
                    sessionStorage.setItem('tabToGoto', 'paymentTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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
// handle purchase button
$(document).on('click', '[data-purchase-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-purchase-edit'));

    $('#displayPurchaseName').html(toTitleCase(jsonDetails.customer_chosen));
    $('#editPurchaseCustomer').val(jsonDetails.customer);
    $('#editFuelStationsPurchase').val(jsonDetails.station_id);
    $('#editPurchaseAmount').val(jsonDetails.amount);
    $('#editPurchaseItems').val(jsonDetails.purchase_items);
    $('#editPurchaseDriver').val(jsonDetails.driver_selected);
    $('#editPurchaseVehicle').val(jsonDetails.driver_vehicle_selected);

    // initiate onchange on the driver
    $("select#editPurchaseDriver").change();

    $('#editPurchaseModal').modal('show');

    /** Edit Purchase API **/
    $("#editPurchaseBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var addPurchaseCustomer = $.trim($('#editPurchaseCustomer').val());
        var addFuelStationsPurchase = $.trim($('#editFuelStationsPurchase').val());
        var addPurchaseAmount = $.trim($('#editPurchaseAmount').val());
        var addPurchaseItems = $.trim($('#editPurchaseItems').val());
        var addPurchaseDriver = $.trim($('#editPurchaseDriver').val());
        var addPurchaseVehicle = $.trim($('#editPurchaseVehicle').val());

        if (addPurchaseCustomer == "" || addPurchaseCustomer == undefined) {
            displayErrorMsgModal("Please select a customer"); //display Error message
            return false;
        }
        else if (addFuelStationsPurchase == "" || addFuelStationsPurchase == undefined) {
            displayErrorMsgModal("Please select filling station"); //display Error message
            return false;
        }
        else if (addPurchaseAmount == "" || addPurchaseAmount == undefined) {
            displayErrorMsgModal("Please enter amount"); //display Error message
            return false;
        }
        else if (addPurchaseItems == "" || addPurchaseItems == undefined) {
            displayErrorMsgModal("Please enter purchase items"); //display Error message
            return false;
        }
        else if (addPurchaseDriver == "" || addPurchaseDriver == undefined) {
            displayErrorMsgModal("Please select a driver"); //display Error message
            return false;
        }
        else if (addPurchaseVehicle == "" || addPurchaseVehicle == undefined) {
            displayErrorMsgModal("Please select a driver vehicle"); //display Error message
            return false;
        }


        else {

            // call userRandomString() to get a random id for the user
            user_id = userRandomString();

            $("#editPurchaseBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.fp_id,
                "addPurchaseCustomer": addPurchaseCustomer,
                "addFuelStationsPurchase": addFuelStationsPurchase,
                "addPurchaseAmount": addPurchaseAmount,
                "addPurchaseItems": addPurchaseItems,
                "addPurchaseDriver": addPurchaseDriver,
                "addPurchaseVehicle": addPurchaseVehicle
            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartPurchaseApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editPurchaseBtn").removeAttr('disabled');

                    // set value in storage to remind tabs to load this 
                    sessionStorage.setItem('tabToGoto', 'purchaseTab');

                    // console.log(data);
                    location.reload();

                    $('#editPurchaseModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editPurchaseBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editPurchaseBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });



});

//DELETE purchase DATA
$(document).on('click', '[data-purchase-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-purchase-delete'));

    var formData = {
        "deleteType": "purchase",
        "deleteId": jsonDetails.fp_id
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
                    sessionStorage.setItem('tabToGoto', 'purchaseTab');

                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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

// // handle drivers button
// $(document).on('click', '[data-driver-edit]', function (e) {

//     var jsonDetails = JSON.parse($(this).attr('data-driver-edit'));

//     $('#driverDisplayName').html(toTitleCase(jsonDetails.name));
//     $('#addBranchSelect').val(jsonDetails.branch_id);
//     $('#addDriverAddress').val(jsonDetails.address);
//     $('#addDobDriver').val(jsonDetails.dob);
//     $('#addDriverName').val(jsonDetails.name);
//     $('#addDriverPhone').val(jsonDetails.mob);
//     $('#addDriverEmail').val(jsonDetails.email);
//     $('#addDeviceSelect').val(jsonDetails.veh_id);

//     $('#addDriversModal').modal('show');

//     // Send the driver data here
//     $("#addDriverBtn").click(function (e) {
//         e.preventDefault();
//         show_modal_loader();

//         var addBranchSelect = $.trim($('#addBranchSelect').val());
//         var addDriverAddress = $.trim($('#addDriverAddress').val());
//         var addDobDriver = $.trim($('#addDobDriver').val());
//         var addDriverName = $.trim($('#addDriverName').val());
//         var addDriverPhone = $.trim($('#addDriverPhone').val());
//         var addDeviceSelect = $.trim($('#addDeviceSelect').val());
//         var addDriverEmail = $.trim($('#addDriverEmail').val());

//         $("#addDriverBtn").prop("disabled", true);
//         var formData = {
//             "driver_id": jsonDetails.driver_id,
//             "addBranchSelect": addBranchSelect,
//             "addDriverAddress": addDriverAddress,
//             "addDobDriver": addDobDriver,
//             "addDriverName": addDriverName,
//             "addDriverPhone": addDriverPhone,
//             "addDeviceSelect": addDeviceSelect,
//             "addDriverEmail": addDriverEmail
//         };

//         formData = JSON.stringify(formData);

//         var request = $.ajax({
//             url: "/addPetrosmartDriverApi",
//             type: "POST",
//             data: formData,
//             contentType: "application/json"
//         });

//         request.done(function (data) {
//             if (data.RESPONSE_CODE == "200") {
//                 $("#addDriverBtn").removeAttr('disabled');

//                 // set value in storage to remind tabs to load this 
//                 sessionStorage.setItem('tabToGoto', 'driverTab');

//                 location.reload();

//                 $('#addDriversModal').modal('hide');
//                 displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

//             }

//             else {
//                 $("#addDriverBtn").removeAttr('disabled');
//                 console.log(data)
//                 displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
//             }
//         });

//         // Handle when it failed to connect
//         request.fail(function (jqXHR, textStatus) {
//             console.log(textStatus);
//             //show the error message
//             $("#addDriverBtn").removeAttr('disabled');
//             displayErrorMsgModal("Sorry, something went wrong");
//         });


//     });

// });

// //DELETE Driver USER DATA
// $(document).on('click', '[data-driver-delete]', function (e) {

//     var jsonDetails = JSON.parse($(this).attr('data-driver-delete'));

//     var formData = {
//         "driver_id": jsonDetails.driver_id
//     };

//     formData = JSON.stringify(formData);

//     swal({
//         title: "Delete " + jsonDetails.name + "?",
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
//                 url: "/deleteDriverUserApi",
//                 type: "POST",
//                 data: formData,
//                 contentType: "application/json"
//             });

//             request.done(function (data) {
//                 if (data.RESPONSE_CODE == "200") {
//                     // set value in storage to remind tabs to load this 
//                     sessionStorage.setItem('tabToGoto', 'driverTab');

//                     location.reload();
//                     displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

//                 }

//                 else {
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

// // handle vehicles button
// $(document).on('click', '[data-vehicle-edit]', function (e) {

//     var jsonDetails = JSON.parse($(this).attr('data-vehicle-edit'));

//     $('#displayVehicleName').html(toTitleCase(jsonDetails.name));
//     $('#editVehicleName').val(jsonDetails.name);
//     $('#editVehicleMake').val(jsonDetails.make);
//     $('#editVehicleModel').val(jsonDetails.model);
//     $('#editVehicleType').val(jsonDetails.veh_type);
//     $('#editVehiclePlate').val(jsonDetails.number_plate);
//     $('#editVehicleFuelType').val(jsonDetails.fuel_type);
//     $('#editVehicleRegistrationDate').val(jsonDetails.reg_date);
//     $('#editVehicleDriverSelect').val(jsonDetails.driver_id);
//     $('#editVehicleBranchSelect').val(jsonDetails.branch_id);

//     // $("#editVehicleBranchSelect option[value='"+jsonDetails.branch_id+"']").prop('selected', true);

//     $('#editVehiclesModal').modal('show');

//     /** ADD Vehicle API **/
//     $("#editVehicleBtn").click(function (e) {
//         e.preventDefault();
//         show_modal_loader();

//         var addVehicleName = $.trim($('#editVehicleName').val());
//         var addVehicleMake = $.trim($('#editVehicleMake').val());
//         var addVehicleModel = $.trim($('#editVehicleModel').val());
//         var addVehicleType = $.trim($('#editVehicleType').val());
//         var addVehiclePlate = $.trim($('#editVehiclePlate').val());
//         var addVehicleFuelType = $.trim($('#editVehicleFuelType').val());
//         var addVehicleRegistrationDate = $.trim($('#editVehicleRegistrationDate').val());
//         var addVehicleDriverSelect = $.trim($('#editVehicleDriverSelect').val());
//         var addVehicleBranchSelect = $.trim($('#editVehicleBranchSelect').val());

//         if (addVehicleName == "" || addVehicleName == undefined) {
//             displayErrorMsgModal("Vehicle Name must be filled"); //display Error message
//             return false;
//         }
//         else if (addVehicleMake == "" || addVehicleMake == undefined) {
//             displayErrorMsgModal("Make must be filled"); //display Error message
//             return false;
//         }
//         else if (addVehicleModel == "" || addVehicleModel == undefined) {
//             displayErrorMsgModal("Model must be filled"); //display Error message
//             return false;
//         }
//         else if (addVehicleType == "" || addVehicleType == undefined) {
//             displayErrorMsgModal("Model must be filled"); //display Error message
//             return false;
//         }
//         else if (addVehicleType == "" || addVehicleType == undefined) {
//             displayErrorMsgModal("Please select vehicle type"); //display Error message
//             return false;
//         }
//         else if (addVehiclePlate == "" || addVehiclePlate == undefined) {
//             displayErrorMsgModal("Please enter vehicle plate"); //display Error message
//             return false;
//         }
//         else if (addVehicleFuelType == "" || addVehicleFuelType == undefined) {
//             displayErrorMsgModal("Please select fuel type"); //display Error message
//             return false;
//         }
//         else if (addVehicleDriverSelect == "" || addVehicleDriverSelect == undefined) {
//             displayErrorMsgModal("Please select driver"); //display Error message
//             return false;
//         }
//         else if (addVehicleBranchSelect == "" || addVehicleBranchSelect == undefined) {
//             displayErrorMsgModal("Please select branch"); //display Error message
//             return false;
//         }

//         else {

//             // call userRandomString() to get a random id for the user
//             user_id = jsonDetails.veh_id;

//             $("#editVehicleBtn").prop("disabled", true);

//             var formData = {
//                 "user_id": user_id,
//                 "addVehicleName": addVehicleName,
//                 "addVehicleMake": addVehicleMake,
//                 "addVehicleModel": addVehicleModel,
//                 "addVehicleType": addVehicleType,
//                 "addVehiclePlate": addVehiclePlate,
//                 "addVehicleFuelType": addVehicleFuelType,
//                 "addVehicleRegistrationDate": addVehicleRegistrationDate,
//                 "addVehicleDriverSelect": addVehicleDriverSelect,
//                 "addVehicleBranchSelect": addVehicleBranchSelect
//             };

//             formData = JSON.stringify(formData);

//             var request = $.ajax({
//                 url: "/addPetrosmartVehicleApi",
//                 type: "POST",
//                 data: formData,
//                 contentType: "application/json"
//             });

//             request.done(function (data) {
//                 if (data.RESPONSE_CODE == "200") {
//                     $("#editVehicleBtn").removeAttr('disabled');

//                     // set value in storage to remind tabs to load this 
//                     sessionStorage.setItem('tabToGoto', 'vehicleTab');

// console.log(data);
//                     location.reload();

//                     $('#editVehiclesModal').modal('hide');
//                     displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
//                 }

//                 else {
//                     $("#editVehicleBtn").removeAttr('disabled');
//                     console.log(data)
//                     displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
//                 }
//             });

//             // Handle when it failed to connect
//             request.fail(function (jqXHR, textStatus) {
//                 console.log(textStatus);
//                 //show the error message
//                 $("#editVehicleBtn").removeAttr('disabled');
//                 displayErrorMsgModal("Sorry, something went wrong");
//             });

//         }

//     });


// });

// //DELETE vehicle DATA
// $(document).on('click', '[data-vehicle-delete]', function (e) {

//     var jsonDetails = JSON.parse($(this).attr('data-vehicle-delete'));

//     var formData = {
//         "deleteType": "vehicle",
//         "deleteId": jsonDetails.veh_id
//     };

//     formData = JSON.stringify(formData);

//     swal({
//         title: "Delete " + jsonDetails.name + "?",
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
//                     sessionStorage.setItem('tabToGoto', 'vehicleTab');

//                     location.reload();
//                     displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

//                 }

//                 else {
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




// Query fuel station forms Data
function getFuelStationsData() {
    var data_table = null;

    $('appFuelStationsDataTable').DataTable().destroy();

    data_table = $('#appFuelStationsDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFuelStationsDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'gps', name: 'gps' },
            { data: 'gps_radius', name: 'gps_radius' },
            { data: 'pos_chosen', name: 'pos_chosen' },
            { data: 'omc_chosen', name: 'omc_chosen' },
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

                    var edit_action = "<a href='#' rel='tooltip' data-station-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit station'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-station-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete station'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}


// Query clustered station forms Data
function getClusteredStationsData() {
    var data_table = null;

    $('appClusteredStationsDataTable').DataTable().destroy();

    data_table = $('#appClusteredStationsDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getClusteredStationsDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'stations_chosen', name: 'stations_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-cluster-station-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit cluster station'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-cluster-station-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete cluster station'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}


// Query fuel attendants forms Data
function getFuelAttendantsData() {
    var data_table = null;

    $('appFuelAttendantsDataTable').DataTable().destroy();

    data_table = $('#appFuelAttendantsDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFuelAttendantsDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'station_chosen', name: 'station_chosen' },
            { data: 'pos_chosen', name: 'pos_chosen' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'dob', name: 'dob' },
            { data: 'email', name: 'email' },
            { data: 'tel', name: 'tel' },
            { data: 'mob', name: 'mob' },
            { data: 'pin', name: 'pin' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-attendant-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit attendant'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-attendant-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete attendant'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}

// // Query fuel vouchers forms Data
// function getFuelVouchersData() {
//     var data_table = null;

//     $('voucherFormDataTable').DataTable().destroy();

//     data_table = $('#voucherFormDataTable').DataTable({
//         processing: true,
//         serverSide: false,
//         language: {
//             "processing": "<div class='-spinner-ring -error-'></div>"
//         },
//         ajax: {
//             url: '/getFuelVouchersDataApi'
//         },
//         columns: [
//             { data: 'DT_RowIndex', name: 'id' },
//             { data: 'customer_chosen', name: 'customer_chosen' },
//             { data: 'type_chosen', name: 'type_chosen' },
//             { data: 'amount', name: 'amount' },
//             { data: 'voucher_code', name: 'voucher_code' },
//             { data: 'date_created', name: 'date_created' },
//             {
//                 data: null,
//                 name: 'actions',
//                 orderable: false,
//                 searchable: false,
//                 className: "td-actions",
//                 render: function (data, type, full, meta) {
//                     var detailsJson = JSON.stringify(data);

//                     var edit_action = "<a href='#' rel='tooltip' data-voucher-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit voucher'><i class='ti-pencil'></i></a>";
//                     var delete_action = "<a href='#' rel='tooltip' data-voucher-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete voucher'><i class='ti-trash'></i></a>";

//                     return edit_action + " " + delete_action;

//                 }
//             },
//         ]
//     });

// }

//getWallet Data
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
            url: '/getWalletFuelStationDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'station_chosen', name: 'station_chosen' },
            { data: 'telco', name: 'telco' },
            { data: 'wallet_num', name: 'wallet_num' },
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

// Query fuel POS forms Data
function getFuelPosData() {
    var data_table = null;

    $('posFormDataTable').DataTable().destroy();

    data_table = $('#posFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getFuelPosDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            // { data: 'station_chosen', name: 'station_chosen' },
            { data: 'make', name: 'make' },
            { data: 'model', name: 'model' },
            { data: 'serial_no', name: 'serial_no' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-pos-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit pos'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-pos-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete pos'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}

// Query OMC forms Data
function getOmcData() {
    var data_table = null;

    $('omcFormDataTable').DataTable().destroy();

    data_table = $('#omcFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getOmcDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
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

                    var edit_action = "<a href='#' rel='tooltip' data-omc-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit omc'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-omc-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete omc'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

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

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}

// Query Purchase forms Data
function getPurchaseData() {
    var data_table = null;

    $('purchaseFormDataTable').DataTable().destroy();

    data_table = $('#purchaseFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getPurchaseDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'customer_chosen', name: 'customer_chosen' },
            { data: 'station_chosen', name: 'station_chosen' },
            { data: 'amount', name: 'amount' },
            { data: 'purchase_items', name: 'purchase_items' },
            { data: 'driver_chosen', name: 'driver_chosen' },
            { data: 'vehicle_chosen', name: 'vehicle_chosen' },
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

                    var edit_action = "<a href='#' rel='tooltip' data-purchase-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit purchase'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-purchase-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete purchase'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}

// // Query Driver forms Data
// function getDriverData() {
//     var data_table = null;

//     $('driversFormDataTable').DataTable().destroy();

//     data_table = $('#driversFormDataTable').DataTable({
//         processing: true,
//         serverSide: false,
//         language: {
//             "processing": "<div class='-spinner-ring -error-'></div>"
//         },
//         ajax: {
//             url: '/getDriverDataApi'
//         },
//         columns: [
//             { data: 'DT_RowIndex', name: 'id' },
//             { data: 'name', name: 'name' },
//             { data: 'address', name: 'address' },
//             { data: 'dob', name: 'dob' },
//             { data: 'email', name: 'email' },
//             { data: 'mob', name: 'mob' },
//             { data: 'branch_chosen', name: 'branch_chosen' },
//             { data: 'vehicle_chosen', name: 'vehicle_chosen' },
//             { data: 'date_created', name: 'date_created' },
//             {
//                 data: null,
//                 name: 'actions',
//                 orderable: false,
//                 searchable: false,
//                 className: "td-actions",
//                 render: function (data, type, full, meta) {
//                     var detailsJson = JSON.stringify(data);

//                     var edit_action = "<a href='#' rel='tooltip' data-driver-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit driver'><i class='ti-pencil'></i></a>";
//                     var delete_action = "<a href='#' rel='tooltip' data-driver-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete driver'><i class='ti-trash'></i></a>";

//                     return edit_action + " " + delete_action;

//                 }
//             },
//         ]
//     });

// }

// // Query Vehicle forms Data
// function getVehicleData() {
//     var data_table = null;

//     $('vehiclesFormDataTable').DataTable().destroy();

//     data_table = $('#vehiclesFormDataTable').DataTable({
//         processing: true,
//         serverSide: false,
//         language: {
//             "processing": "<div class='-spinner-ring -error-'></div>"
//         },
//         ajax: {
//             url: '/getVehicleDataApi'
//         },
//         columns: [
//             { data: 'DT_RowIndex', name: 'id' },
//             { data: 'name', name: 'name' },
//             { data: 'driver_chosen', name: 'driver_chosen' },
//             { data: 'make', name: 'make' },
//             { data: 'model', name: 'model' },
//             { data: 'veh_type', name: 'veh_type' },
//             { data: 'number_plate', name: 'number_plate' },
//             { data: 'fuel_type', name: 'fuel_type' },
//             { data: 'reg_date', name: 'reg_date' },
//             { data: 'branch_chosen', name: 'branch_chosen' },
//             { data: 'date_created', name: 'date_created' },
//             {
//                 data: null,
//                 name: 'actions',
//                 orderable: false,
//                 searchable: false,
//                 className: "td-actions",
//                 render: function (data, type, full, meta) {
//                     var detailsJson = JSON.stringify(data);

//                     var edit_action = "<a href='#' rel='tooltip' data-vehicle-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit driver'><i class='ti-pencil'></i></a>";
//                     var delete_action = "<a href='#' rel='tooltip' data-vehicle-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete driver'><i class='ti-trash'></i></a>";

//                     return edit_action + " " + delete_action;

//                 }
//             },
//         ]
//     });

// }



// Delivery Date Picker Component
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

// This will handle whether to show voucher code field or not for payment type
function getPaymentType(selectedValue) {
    var value = selectedValue.value.toUpperCase();

    if (value == "VOUCHER") {
        $("#voucherDiv").show("fast");
        $("#editVoucherDiv").show("fast");
        $("#companyAmountDiv").hide("fast");
        $("#multipleAmountDiv").hide("fast");
    }
    else {
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

    }
    else {
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
                console.log(data.RESPONSE_DATA);

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

    }
    else {
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
                }
                else {
                    $("#multipleOnlyDiv").hide("fast");
                }


                $("#addVoucherType").val(responseData.type_chosen);
                $("#voucherTypeIdentified").html(responseData.type_chosen);
                $("#totalVoucherAmount").html(responseData.amount);
                $("#totalVoucherBalance").html(responseData.amount - responseData.balance_left);
                $("#multipleAmountDiv").show("fast");

                // console.log(data.RESPONSE_DATA);
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get voucher usage type");
        });

    }
}

// This will get all the vehicles for a particular driver
function getPurchaseDriverVehicles(selectedValue) {
    var value = selectedValue.value;

    console.log("selected", value);

    if (value == "" || value == undefined || value == null) {
        // Clear the old data
        $('#addPurchaseVehicle')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Vehicle </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        // Clear the old data
        $('#editPurchaseVehicle')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Select Vehicle </option>')
            .val('')
        // .append('<option value="new">New Supplier</option>')
        // .val('new');

        return false;

    }
    else {
        //   lets get the voucher usage type
        show_modal_loader();

        var formData = {
            "driverId": value
        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/getDriverVehiclesApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {

                // Clear the old data
                $('#addPurchaseVehicle')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Select Vehicle </option>')
                    .val('')
                // .append('<option value="new">New Supplier</option>')
                // .val('new');

                var allData = data.RESPONSE_DATA;

                if (allData) {
                    // console.log("alldata", allData);

                    var select = $('#addPurchaseVehicle');
                    var select2 = $('#editPurchaseVehicle');

                    for (i = 0; i < allData.length; i++) {
                        mainData = allData[i];

                        select.append($("<option></option>").attr("value", mainData["veh_id"]).text(mainData["name"]));
                        select2.append($("<option></option>").attr("value", mainData["veh_id"]).text(mainData["name"]));

                    }

                    $('.purchaseVehicleSelectpicker').selectpicker();

                }

                displaySuccessMsgModal(data.RESPONSE_MESSAGE);
                console.log(data.RESPONSE_DATA);

            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            displayErrorMsgModal("Sorry Connection failed")
            console.log("Failed to get customer vouchers");
        });

    }
}
