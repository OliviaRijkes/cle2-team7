<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}
// public/index.php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/rooms.php';
require_once __DIR__ . '/../includes/reservations.php';

$rooms = rooms_list($db);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    <link rel="stylesheet" href="assets/app.css">
    <script src="assets/darkmode.js"></script>
</head>
<body>
<button onclick="darkToggle()">darkmode toggle</button>
<header>
    <section>
        <div class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </div>
        <div class="dropdown_in_header">
            <div class="dropdown">
                <button class="dropbtn"></button> <!-- Hier komt nog een foto -->
                <nav class="dropdown-content">
                    <a href="logout.php">Uitloggen</a>
                    <a href="">Mijn reserveringen</a>
                    <a href="">Reserveringen veranderen</a>
                </nav>
            </div>
        </div>
    </section>
</header>
<main>
    <section class="agenda_content">
        <div class="room_info">
            <h2 class="room_header">Reserveringen</h2>
            <div class="room_stuff">
                <h3 class="heada">Zalen overzicht</h3>
                <div class="actual_rooms">
<!--                foreach room-->
                    <a href="">Zaal 1</a>
                    <a href="">Zaal 2</a>
                    <a href="">Zaal 3</a>
                    <a href="">Zaal 4</a>

                </div>
                <div class="actual_filter">
                    <h4>Filter</h4>
                    <a href="">0 -----</a>
                    <a href="">0 -----</a>
                    <a href="">0 -----</a>
                </div>
            </div>
        </div>

        <div class="agenda">
            <div class="filter_view">
                <a class="button_day">Dag</a>
                <a class="button_week">Week</a>
                <a class="button_month">Maand</a>
            </div>
            <div class="actual_agenda">agenda</div>
        </div>

    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>