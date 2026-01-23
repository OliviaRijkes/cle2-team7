<?php
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'bouw_reserveringen';

$db = mysqli_connect($host, $username, $password, $database);
$sound_system = '';
$check = true;
if (isset($_POST['super'])) {
    $digiboard = $_POST['digiboard'];
    $sound_system = $_POST['sound_system'];
    $capacity = $_POST['capacity'];
    $surface = $_POST['surface'];

    $errors = [];
    if ($digiboard === "2" && $sound_system === "2") {
        $check = false;
        require_once '../includes/db.php';
        $query = "SELECT * FROM `rooms` WHERE capacity >= '$capacity' AND is_active = 1 AND surface_area >= '$surface' AND sound_system IN (0, 1) AND digiboard IN (0, 1)";

        $result = mysqli_query($db, $query);
        $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $result = mysqli_query($db, $query);
    }

    if ($digiboard === "2" && $sound_system !== "2") {
        $check = false;
        require_once '../includes/db.php';
        $query = "SELECT * FROM `rooms` WHERE capacity >= '$capacity' AND is_active = 1 AND surface_area >= '$surface' AND sound_system = '$sound_system' AND digiboard IN (0, 1)";

        $result = mysqli_query($db, $query);
        $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $result = mysqli_query($db, $query);
    }

    if ($digiboard !== "2" && $sound_system === "2") {
        $check = false;
        require_once '../includes/db.php';
        $query = "SELECT * FROM `rooms` WHERE capacity >= '$capacity' AND is_active = 1 AND surface_area >= '$surface' AND sound_system in (0, 1) AND digiboard = '$digiboard'";

        $result = mysqli_query($db, $query);
        $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $result = mysqli_query($db, $query);
    }


    if ($check === true) {

        $host = '127.0.0.1';
        $username = 'root';
        $password = '';
        $database = 'bouw_reserveringen';

        $db = mysqli_connect($host, $username, $password, $database);

        $query = "SELECT * FROM `rooms` WHERE capacity >= '$capacity' AND is_active = 1 AND surface_area >= '$surface' AND sound_system = '$sound_system' AND digiboard = '$digiboard'";

        $result = mysqli_query($db, $query);
        $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $result = mysqli_query($db, $query);
    }


}
if (isset($_POST['reset'])) {
    $host = '127.0.0.1';
    $username = 'root';
    $password = '';
    $database = 'bouw_reserveringen';

    $db = mysqli_connect($host, $username, $password, $database);

    $query = "SELECT * FROM `rooms`";

    $result = mysqli_query($db, $query);
    $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $result = mysqli_query($db, $query);
}

?>


<div class="filter_rooms">
    <h3>Filter</h3>
    <form action="" method="post">
        <div class="filter_form">
            <div class="form_content">
                <div class="form_capacity">
                    <label for="capacity">Capacity</label>
                    <input type="text" id="chairs" name="capacity">
                </div>
                <div class="form_digiboard">
                    <label for="digiboard">Digiboard</label>
                    <select name="digiboard" id="digiboard">
                        <option selected value="2">No Filter</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form_sound_system">
                    <label for="sound_system">Sound system</label>
                    <select name="sound_system" id="sound_system">
                        <option selected value="2">No Filter</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form_surface">
                    <label for="surface">Surface (m²)</label>
                    <input type="text" id="surface" name="surface">
                </div>
            </div>
            <div class="btn-group">
                <button type="submit" name="super">Save Filter</button>
                <button type="submit" name="reset">Reset Filter</button>
            </div>
        </div>
    </form>
</div>
