$(document).ready(function () {
    initiateSubHeadings();
    getNotificationsData();
    getNotificationArray();
});

// Initiate the subheadings form here
function initiateSubHeadings() {

    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><br/><input type="text" class="notifyForm" id="add_sub_heading_name" placeholder="Enter an Alert"/><a href="javascript:void(0);" class="remove_button">&nbsp;&nbsp;<span><i class="ti-close"></i></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
}

$("#addNotificationsBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    var user_id;
    var mainHeading = $.trim($('#addMainHeading').val());

    // Get all the values of the subheadings
    var subHeading = $(".notifyForm").map(function () { return this.value }).get();

    if (mainHeading == "" || mainHeading == undefined) {
        displayErrorMsgModal("Main Notification Title must be filled"); //display Error message
        return false;
    }

    else if (subHeading.length == 0 || subHeading.length == undefined) {
        displayErrorMsgModal("Alerts must be entered"); //display Error message
        return false;
    }

    else {

        // call userRandomString() to get a random id for the user
        user_id = userRandomString();

        $("#addNotificationsBtn").prop("disabled", true);

        var formData = {
            "user_id": user_id,
            "mainHeading": mainHeading,
            "subHeading": subHeading.toString(),

        };

        formData = JSON.stringify(formData);

        var request = $.ajax({
            url: "/addPetrosmartNotificationApi",
            type: "POST",
            data: formData,
            contentType: "application/json"
        });

        request.done(function (data) {
            if (data.RESPONSE_CODE == "200") {
                $("#addNotificationsBtn").removeAttr('disabled');

                location.reload();

                $('#addNotificationModal').modal('hide');
                displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
            }

            else {
                $("#addNotificationsBtn").removeAttr('disabled');
                // console.log(data)
                displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
            }
        });

        // Handle when it failed to connect
        request.fail(function (jqXHR, textStatus) {
            console.log(textStatus);
            //show the error message
            $("#addNotificationsBtn").removeAttr('disabled');
            displayErrorMsgModal("Sorry, something went wrong");
        });

    }

});

// Query notifications forms Data
function getNotificationsData() {
    var data_table = null;

    $('notificationsFormDataTable').DataTable().destroy();

    data_table = $('#notificationsFormDataTable').DataTable({
        processing: true,
        serverSide: false,
        language: {
            "processing": "<div class='-spinner-ring -error-'></div>"
        },
        ajax: {
            url: '/getNotificationsDataApi'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'heading', name: 'heading' },
            { data: 'sub_heading_chosen', name: 'sub_heading_chosen' },
            { data: 'date_created', name: 'date_created' },
            {
                data: null,
                name: 'actions',
                orderable: false,
                searchable: false,
                className: "td-actions",
                render: function (data, type, full, meta) {
                    var detailsJson = JSON.stringify(data);

                    var edit_action = "<a href='#' rel='tooltip' data-notification-edit='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='edit notificaton'><i class='ti-pencil'></i></a>";
                    var delete_action = "<a href='#' rel='tooltip' data-notification-delete='" + detailsJson + "' class='' data-toggle='tooltip' data-placement='bottom' title='delete notificaton'><i class='ti-trash'></i></a>";

                    return edit_action + " " + delete_action;

                }
            },
        ]
    });

}

// Query the notifications LIST
function getNotificationArray() {
    var request = $.ajax({
        url: "/getNotificationArrayApi",
        type: "GET",
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            loadNotificationsData(data);

            // save the length of the notification into storage
            sessionStorage.setItem("notificationCount", data.RESPONSE_DATA.length);
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log("Failed to pull notifications");
    });

}

// load the html notifications table view here
function loadNotificationsData(allData) {
    var data = allData.RESPONSE_DATA;
    var assignedNotifications = allData.ASSIGNED_DATA[0];

    // Initiate table list here
    var table_list = "";

    // give a count to 
    var driverCount = 0;
    var managerCount = 0;

    if (data) {

        // get the data that was assigned

        var managerData = JSON.parse(assignedNotifications.manager);
        var driverData = JSON.parse(assignedNotifications.driver);

        var newManagerArray = [];
        var newDriverArray = [];

        // Perform for loops for Mnaager

        // first for loop through the objec
        for (m = 0; m < managerData.length; m++) {
            newData = managerData[m];

            if (newData["data"] !== undefined) {
                notificationData = newData["data"]["notifications"];

                // nested for looop put all the manager notification data together
                for (n = 0; n < notificationData.length; n++) {
                    newManagerArray.push(notificationData[n]);
                }
            }

            else {
                continue;
            }

        }

        // lets do for Driver
        for (d = 0; d < driverData.length; d++) {
            newData = driverData[d];

            if (newData["data"] !== undefined) {
                notificationData = newData["data"]["notifications"];

                // nested for looop put all the manager notification data together
                for (e = 0; e < notificationData.length; e++) {
                    newDriverArray.push(notificationData[e]);
                }
            }

            else {
                continue;
            }
        }

        // console.log("managerData", newManagerArray)
        // console.log("driverData", newDriverArray)


        for (i = 0; i < data.length; i++) {
            mainData = data[i];

            // declare empty variables to pick the Notifications
            sub_actions_list = "";
            sub_actions_manager_list = "";
            sub_actions_driver_list = "";


            // lets get the subheadings here
            subActionData = JSON.parse(JSON.stringify(mainData.sub_headings));

            // Perform a split action to turn it into an array
            subActionArray = subActionData.split(",");

            for (j = 0; j < subActionArray.length; j++) {
                sub_actions_list += "<p>" + subActionArray[j] + "</p>";

                // we use the include to check 
                if (newManagerArray.includes(subActionArray[j]) == true) {
                    sub_actions_manager_list += "<p>" +
                        "<div class='styled-checkbox'>" +
                        "<input type='checkbox' name='" + "checkboxManager-" + mainData.notify_id + "' id='" + "managerCheck-" + managerCount + "' value='" + subActionArray[j] + "' checked>" +
                        "<label for='" + "managerCheck-" + managerCount + "'></label>" +
                        "</div>" +
                        "</p>";
                }

                else {
                    sub_actions_manager_list += "<p>" +
                        "<div class='styled-checkbox'>" +
                        "<input type='checkbox' name='" + "checkboxManager-" + mainData.notify_id + "' id='" + "managerCheck-" + managerCount + "' value='" + subActionArray[j] + "'>" +
                        "<label for='" + "managerCheck-" + managerCount + "'></label>" +
                        "</div>" +
                        "</p>";
                }


                // lets do the same for driver
                if (newDriverArray.includes(subActionArray[j]) == true) {

                    sub_actions_driver_list += "<p>" +
                        "<div class='styled-checkbox'>" +
                        "<input type='checkbox' name='" + "checkboxDriver-" + mainData.notify_id + "' id='" + "driverCheck-" + driverCount + "' value='" + subActionArray[j] + "' checked>" +
                        "<label for='" + "driverCheck-" + driverCount + "'></label>" +
                        "</div>" +
                        "</p>";

                }

                else {
                    sub_actions_driver_list += "<p>" +
                        "<div class='styled-checkbox'>" +
                        "<input type='checkbox' name='" + "checkboxDriver-" + mainData.notify_id + "' id='" + "driverCheck-" + driverCount + "' value='" + subActionArray[j] + "'>" +
                        "<label for='" + "driverCheck-" + driverCount + "'></label>" +
                        "</div>" +
                        "</p>";
                }

                driverCount++;
                managerCount++;
            }

            table_list +=
                "<tr>" +
                "<td style='display:none;'><input id='" + "notification-" + i + "' value='" + mainData.notify_id + "' /></td>" +
                "<td>" +
                "<p><label>" + mainData.heading + "</label></p>" +
                sub_actions_list +
                "</td>" +

                "<td>" +
                "<p><label></label></p>" +
                sub_actions_manager_list +
                "</td>" +

                "<td>" +
                "<p><label></label></p>" +
                sub_actions_driver_list +
                "</td>" +
                // "<td>" + mainData.voucher_code + "</td>" +

                "</tr>"
        }

        $('#populateNotficationsBody').html(table_list);
    }

}


// when the submit notifications btn is clicked

$("#assignNotificationsBtn").click(function (e) {
    e.preventDefault();
    show_modal_loader();

    // lets get the values and create json bodies here from the checkboxes

    // get the count of the notifications
    var notificationCount = sessionStorage.getItem("notificationCount");

    var notifyIds = [];
    var managerNotifyArray = [];
    var driverNotifyArray = [];


    // loop through the notification count so as to get the ID's which is invisible stored in the table
    for (i = 0; i < notificationCount; i++) {
        pickFormId = $("#notification-" + i).val();
        driverObject = {};
        managerObject = {};

        // this will handle the checkbox items and put them in array with respect to their ID's
        driverNotify = [];
        managerNotify = [];

        // push all the selected managers noifications into this array
        $.each($("input[name='" + "checkboxManager-" + pickFormId + "']:checked"), function () {

            //lets create an Object so as to seperate the notifications based on id's
            //push the values from the check box
            managerNotify.push($(this).val())
            managerObject["data"] = { "id": pickFormId, "notifications": managerNotify }


        });

        // push all the selected drivers noifications into this array
        $.each($("input[name='" + "checkboxDriver-" + pickFormId + "']:checked"), function () {
            //push the values from the check box
            driverNotify.push($(this).val());
            driverObject["data"] = { "id": pickFormId, "notifications": driverNotify }

        });


        //push all created object
        driverNotifyArray.push(driverObject);
        managerNotifyArray.push(managerObject);

        notifyIds.push($("#notification-" + i).val());
    }


    console.log("notifyIds-->>>>", notifyIds);
    console.log("manager-->>>>", managerNotifyArray);
    console.log("driver---->>>", driverNotifyArray);

    $("#assignNotificationsBtn").prop("disabled", true);

    var formData = {
        "notify_id": notifyIds,
        "manager": JSON.stringify(managerNotifyArray),
        "driver": JSON.stringify(driverNotifyArray)
        // "manager": managerNotifyArray,
        // "driver": driverNotifyArray
    };

    formData = JSON.stringify(formData);

    var request = $.ajax({
        url: "/assignPetrosmartNotificationApi",
        type: "POST",
        data: formData,
        contentType: "application/json"
    });

    request.done(function (data) {
        if (data.RESPONSE_CODE == "200") {
            $("#assignNotificationsBtn").removeAttr('disabled');

            location.reload();

            $('#assignNotificationModal').modal('hide');
            displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
        }

        else {
            $("#assignNotificationsBtn").removeAttr('disabled');
            // console.log(data)
            displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
        }
    });

    // Handle when it failed to connect
    request.fail(function (jqXHR, textStatus) {
        console.log(textStatus);
        //show the error message
        $("#assignNotificationsBtn").removeAttr('disabled');
        displayErrorMsgModal("Sorry, something went wrong");
    });



});


// Edit notifications 
$(document).on('click', '[data-notification-edit]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-notification-edit'));

    // initiate the dynamic form fields here
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.add_button_edit'); //Add button selector
    var wrapper = $('.field_wrapper_edit'); //Input field wrapper
    var fieldHTML = '<div><br/><input type="text" class="notifyFormEdit" id="edit_sub_heading_name" placeholder="Enter an Alert"/><a href="javascript:void(0);" class="remove_button_edit">&nbsp;&nbsp;<span><i class="ti-close"></i></span></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button_edit', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    // let the modal data info filling begin here
    $("#displayNotificationHead").html(jsonDetails.heading);
    $("#editMainHeading").val(jsonDetails.heading);

    // get the subheadings here
    var subHeadingData = jsonDetails.sub_headings;
    var subHeadingArray = subHeadingData.split(",");

    var htmlString = "";

    for (i = 0; i < subHeadingArray.length; i++) {
        htmlString += '<div><br/><input type="text" class="notifyFormEdit" id="edit_sub_heading_name" placeholder="Enter an Alert" value="' + subHeadingArray[i] + '" /><a href="javascript:void(0);" class="remove_button_edit">&nbsp;&nbsp;<span><i class="ti-close"></i></span></a></div>';
    }

    //To refresh the count on the cards

    $("#editSubHeadingInput").html(htmlString);

    $("#editNotificationModal").modal("show");



    // Now lets send the data to DB

    $("#editNotificationsBtn").click(function (e) {
        e.preventDefault();
        show_modal_loader();

        var user_id;
        var mainHeading = $.trim($('#editMainHeading').val());

        // Get all the values of the subheadings
        var subHeading = $(".notifyFormEdit").map(function () { return this.value }).get();

        if (mainHeading == "" || mainHeading == undefined) {
            displayErrorMsgModal("Main Notification Title must be filled"); //display Error message
            return false;
        }

        else if (subHeading.length == 0 || subHeading.length == undefined) {
            displayErrorMsgModal("Alerts must be entered"); //display Error message
            return false;
        }

        else {

            // call userRandomString() to get a random id for the user
            // user_id = userRandomString();

            $("#editNotificationsBtn").prop("disabled", true);

            var formData = {
                "user_id": jsonDetails.notify_id,
                "mainHeading": mainHeading,
                "subHeading": subHeading.toString(),

            };

            formData = JSON.stringify(formData);

            var request = $.ajax({
                url: "/addPetrosmartNotificationApi",
                type: "POST",
                data: formData,
                contentType: "application/json"
            });

            request.done(function (data) {
                if (data.RESPONSE_CODE == "200") {
                    $("#editNotificationsBtn").removeAttr('disabled');

                    location.reload();

                    $('#editNotificationModal').modal('hide');
                    displaySuccessToastModal(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST
                }

                else {
                    $("#editNotificationsBtn").removeAttr('disabled');
                    // console.log(data)
                    displayErrorMsgModal(toTitleCase(data.RESPONSE_MESSAGE)); //display Error message
                }
            });

            // Handle when it failed to connect
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus);
                //show the error message
                $("#editNotificationsBtn").removeAttr('disabled');
                displayErrorMsgModal("Sorry, something went wrong");
            });

        }

    });

});


// Delete notification
$(document).on('click', '[data-notification-delete]', function (e) {

    var jsonDetails = JSON.parse($(this).attr('data-notification-delete'));

    var formData = {
        "deleteType": "notification",
        "deleteId": jsonDetails.notify_id
    };

    formData = JSON.stringify(formData);

    swal({
        title: "Delete " + jsonDetails.heading + "?",
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
                    location.reload();
                    displaySuccessToast(toTitleCase(data.RESPONSE_MESSAGE), ""); //DISPLAY TOAST

                }

                else {
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

