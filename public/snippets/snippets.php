<tr>
    <td>
        <p><label>Verification Issues</label></p>
        <p>PIN</p>
        <p>VEHICLE</p>
    </td>

    <td>
        <p><label></label></p>
        <p>
            <div class='styled-checkbox'>
                <input type='checkbox' name='checkboxWeekDays' id='check-01' value='Sunday'>
                <label for='check-01'></label>
            </div>
        </p>

        <p>
            <div class='styled-checkbox'>
                <input type='checkbox' name='checkboxWeekDays' id='check-02' value='Sunday'>
                <label for='check-02'></label>
            </div>
        </p>
    </td>

    <td>
        <p><label></label></p>
        <p>
            <div class='styled-checkbox'>
                <input type='checkbox' name='checkboxWeekDays' id='check-1' value='Sunday'>
                <label for='check-1'></label>
            </div>
        </p>

        <p>
            <div class='styled-checkbox'>
                <input type='checkbox' name='checkboxWeekDays' id='check-2' value='Sunday'>
                <label for='check-2'></label>
            </div>
        </p>
    </td>
</tr>



// upload for manager first
foreach ($allManagerList as $manager) {

// loop through the object
foreach ($manager as $index => $key) {

//lets check if the id is the same with the main one looping

if (PetrosmartNotifications::where("notify_id", $key["id"])->exists()) {
$creatorForm = PetrosmartNotifications::where("notify_id", $key["id"])->first();

$creatorForm->manager = $key;
}
}
}