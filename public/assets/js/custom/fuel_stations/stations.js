$(document).ready(function () {
    getFuelStationsData();
    getPosArray();
    getOmcArray();
    getCountriesArray();
});

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