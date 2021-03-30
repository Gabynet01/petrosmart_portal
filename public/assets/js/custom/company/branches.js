var addPetrosmartBranchApi = "/addPetrosmartBranchApi";

$(document).ready(function () {
    getBranchUsersData();
    getCustomersArray();
    getCountriesArray();
    getClusteredArray();
    addTimeOfDayToCard();
    addTimeOfDayToCardShow();
});

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

    if (addBranchContact2 == "" || addBranchContact2 == NaN || addBranchContact2 == undefined) {
        addBranchContact2 = "";
        // displayErrorMsgModal("Branch Contact 2 must be filled"); //display Error message
    }

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

        if (addBranchContact2 == "" || addBranchContact2 == NaN || addBranchContact2 == undefined) {
            addBranchContact2 = "";
            // displayErrorMsgModal("Branch Contact 2 must be filled"); //display Error message
        }

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