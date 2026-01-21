<?php
/** @var mysqli $db */
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}
$id = $_SESSION["id"];
require_once '../includes/db.php';
$query = "SELECT rooms.name AS room_name, 
                 users.firstname AS user_name,
                 reservations.title, 
                 reservations.start_datetime, reservations.end_datetime
            FROM reservations 
                INNER JOIN users ON users.id = reservations.user_id
                INNER JOIN rooms ON rooms.id = reservations.room_id
            WHERE users.id = '$id'
            ORDER BY start_datetime";
$result = mysqli_query($db, $query);
$roomReservations = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($db);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gereserveerde kamers</title>
    <link rel="stylesheet" href="assets/app.css">
    <link rel="stylesheet" href="assets/details.css">
    <script defer src="assets/darkmode.js"></script>
    <script>
        function detailSearch() {
            var input = document.getElementById("detailSearchInput");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("detailTable");
            var tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];
                if (td) {
                    textValue = td.textContent || td.innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>
    <?php include __DIR__ . '/../includes/header.php'; ?>
<body class="details_body">
    <section class="details_section">
        <div class="greetings">
            <h1>Hallo, <?= ucfirst($_SESSION['firstname'])?> </h1>
            <div class="detail_input">
                <input type="text" id="detailSearchInput" onkeyup="detailSearch()" placeholder="Zoek naar reservering...">
            </div>
        </div>
        <div class="detail_table_div">
            <h2> Jouw Reserveringen </h2>
            <table id="detailTable" class="details_table_body">
                <thead>
                    <tr>
                        <th>Begin tijd</th>
                        <th>Eind tijd</th>
                        <th>Zaal</th>
                        <th>Personen</th>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roomReservations as $reservation) { ?>
                        <tr>
                            <td> <?= $reservation['start_datetime']; ?> </td>
                            <td> <?= $reservation['end_datetime']; ?> </td>
                            <td> <?= $reservation['room_name'] ?> </td>
                            <td> <?= $reservation['user_name'] ?> </td>
                            <td> <?= $reservation['title'] ?> </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </section>
</body>

    <?php include __DIR__ . '/../includes/footer.php';?>
</html>