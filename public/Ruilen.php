<?php

/** @var mysqli $db */
require_once '../includes/db.php';
// example kamers, de 6 en 7 zijn de id in de database, dit kan later met een get request opgehaald vorden
$example1 = 6;
$example2 = 7;



// query om de twee zalen op te halen,
$query = "SELECT * FROM reservations WHERE id in ('$example1', '$example2')";
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
                 SET user_id = '$user2'
                 WHERE id = '$example1'";
    $query2_1 = "UPDATE reservations 
                 SET user_id = '$user1'
                 WHERE id = '$example2'";
$result1_2 = mysqli_query($db, $query1_2);
$result2_1 = mysqli_query($db, $query2_1);

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
        <h3> Kamer:     <?= $room1; ?> </h3>
        <h3> Gebruiker: <?= $user1; ?> </h3>
        <h3> Title:     <?= $title1; ?> </h3>
        <h3> Begin tijd:<?= $start1; ?> </h3>
        <h3> Eind tijd: <?= $end1; ?> </h3>
    </section>
    <h1>kamer 2</h1>
    <section>
        <h3> Kamer:     <?= $room2 ?> </h3>
        <h3> Gebruiker: <?= $user2 ?> </h3>
        <h3> Title:     <?= $title2 ?> </h3>
        <h3> Begin tijd:<?= $start2 ?> </h3>
        <h3> Eind tijd: <?= $end2 ?> </h3>
    </section>
    <form action="" method="post">
    <button type="submit" name="submit"> Akkoord </button>
    <button> Afwijzen </button>
    </form>
</body>

</html>
