<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}
// public/index.php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/rooms.php';
require_once __DIR__ . '/../includes/reservations.php';

$rooms  = rooms_list($db);
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
    <section>
        <div class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </div>
        <div class="dropdown_in_header">
            <div class="dropdown">
                <button class="dropbtn"></button> <!-- Hier komt nog een foto -->
                <div class="dropdown-content">
                    <a href="logout.php">Uitloggen</a>
                    <a href="">Mijn reserveringen</a>
                    <a href="">Reserveringen veranderen</a>
                </div>
            </div>
        </div>
    </section>
</header>
<main>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>