<?php

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

/** @var mysqli $db */
require_once __DIR__ . '/../includes/db.php';

if ($_GET['a'] > $_GET['b']) {
    $example1 = (int)($_GET['b']);
    $example2 = (int)($_GET['a']);
} else {
    $example1 = (int)($_GET['a']);
    $example2 = (int)($_GET['b']);
}




// query om de twee zalen op te halen,
$query = "
    SELECT *
    FROM reservations
    WHERE id IN ($example1, $example2)";

// display de 2 zalen
$result = mysqli_query($db, $query);
$test = mysqli_fetch_all($result);

// kamers in aparte arrays
$room1 = $test[0][1];
$user1 = $test[0][2];
$title1 = $test[0][3];
$start1 = $test[0][4];
$end1 = $test[0][5];


$room2 = $test[1][1];
$user2 = $test[1][2];
$title2 = $test[1][3];
$start2 = $test[1][4];
$end2 = $test[1][5];

// if submit
if (isset($_POST['submit'])) {
    //update de aangepaste zalen
    $query1_2 = "UPDATE reservations 
                 SET room_id = '$room2'
                 WHERE id = '$example1'";
    $query2_1 = "UPDATE reservations 
                 SET room_id = '$room1'
                 WHERE id = '$example2'";
    $result1_2 = mysqli_query($db, $query1_2);
    $result2_1 = mysqli_query($db, $query2_1);

    mysqli_query($db, $query1_2);
    mysqli_query($db, $query2_1);

    header("Location: index.php");
    exit;
}

// afwijzen -> terug
if (isset($_POST['reject'])) {
    header("Location: index.php");
    exit;
}







?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Ruilen</title>
    <link rel="stylesheet" href="assets/app.css">
</head>

<body>
    <h1>kamer 1</h1>
    <section>
        <p> Kamer:     <?= $room1; ?> </p>
        <p> Gebruiker: <?= $user1; ?> </p>
        <p> Title:     <?= $title1; ?> </p>
        <p> Begin tijd:<?= $start1; ?> </p>
        <p> Eind tijd: <?= $end1; ?> </p>
    </section>
    <h1>kamer 2</h1>
    <section>
        <p> Kamer:     <?= $room2 ?> </p>
        <p> Gebruiker: <?= $user2 ?> </p>
        <p> Title:     <?= $title2 ?> </p>
        <p> Begin tijd:<?= $start2 ?> </p>
        <p> Eind tijd: <?= $end2 ?> </p>
    </section>
    <form action="" method="post">
    <button type="submit" name="submit"> Akkoord </button>
    <button type="submit" name="reject" value="1"> Afwijzen </button>
    </form>
</body>
</html>
