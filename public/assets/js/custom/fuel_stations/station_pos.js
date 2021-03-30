$(document).ready(function () {
    getFuelPosData();
});

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