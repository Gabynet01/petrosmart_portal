$(document).ready(function () {
    getClusteredStationsData();
    getFuelStationsArray();
});

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




// handle clustered stations button
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

//DELETE CLUSTERED STATION DATA
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

