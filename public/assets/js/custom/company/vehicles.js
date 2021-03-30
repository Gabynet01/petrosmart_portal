var addPetrosmartBranchApi = "/addPetrosmartBranchApi";

$(document).ready(function () {
    getVehicleData();
    getAllDriversArray();
    getCustomersArray();
    getClusteredArray();
    registrationDatePicker();
    editregistrationDatePicker();
    addTimeOfDayToCard();
    addTimeOfDayToCardShow();
});

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