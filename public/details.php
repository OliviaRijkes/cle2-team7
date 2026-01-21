<?php
/** @var mysqli $db */
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

if(!isset($_GET['id']) || $_GET['id'] === '') {
    header('Location: login.php');
    exit;
}
require_once '../includes/db.php';
$id = $_GET['id'];
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
</head>
    <?php include __DIR__ . '/../includes/header.php'; ?>
<body class="details_body">
    <section class="details_section">
        <div class="greetings">
            <h1>Hallo, <?= ucfirst($_SESSION['firstname'])?> </h1>

        </div>
        <div class="detail_table_div">
            <h2> Jouw Reserveringen </h2>
            <table class="details_table_body">
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
                            <th> <?= $reservation['start_datetime']; ?> </th>
                            <th> <?= $reservation['end_datetime']; ?> </th>
                            <th> <?= $reservation['room_name'] ?> </th>
                            <th> <?= $reservation['user_name'] ?> </th>
                            <th> <?= $reservation['title'] ?> </th>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </section>
</body>

    <?php include __DIR__ . '/../includes/footer.php';?>
</html>