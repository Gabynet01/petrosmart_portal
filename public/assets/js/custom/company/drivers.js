var addPetrosmartBranchApi = "/addPetrosmartBranchApi";

$(document).ready(function () {
    getDriverData();
    getCustomersArray();
    getAllVehiclesArray();
    getAllDevicesArray();
    getClusteredArray();
    dateOfBirthDriverPicker();
    editDateOfBirthPicker();
    addTimeOfDayToCard();
    addTimeOfDayToCardShow();
});

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

//edit date of birth picker
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

// Date of birth Picker Component
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
