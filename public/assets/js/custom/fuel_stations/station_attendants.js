$(document).ready(function () {
    getFuelAttendantsData();
    getPosArray();
    getFuelStationsArray();
    dateOfBirthPicker();
    editDateOfBirthPicker();
});


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

//Date picker
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