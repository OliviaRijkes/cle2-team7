<?php
// public/index.php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/rooms.php';
require_once __DIR__ . '/../includes/reservations.php';

reservation_save_from_post($db);

$rooms  = rooms_list($db);
$events = reservations_events($db);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="/assets/app.css">
</head>
<body>
<header>
    <div class="logo_in_header">
        <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
    </div>
    <div class="dropdown">
        <button class="dropbtn"></button> <!-- Hier komt nog een foto -->
        <div class="dropdown-content">
            <a href="">Uitloggen</a>
            <a href=""></a>
            <a href=""></a>
        </div>
    </div>
</header>
<main>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>