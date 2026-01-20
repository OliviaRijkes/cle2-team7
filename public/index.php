<?php
// public/index.php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/rooms.php';
require_once __DIR__ . '/../includes/reservations.php';

$rooms  = rooms_list($db);
$events = reservations_events($db);
$currentUserId = (int)$_SESSION['id'];
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>

    <link rel="stylesheet" href="assets/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">
</head>
<body>

<header>
    <section>
        <div class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </div>

        <div class="dropdown_in_header">
            <div class="dropdown">
                <button class="dropbtn"></button>
                <nav class="dropdown-content">
                    <a href="logout.php">Uitloggen</a>
                    <a href="#">Mijn reserveringen</a>
                    <a href="#">Reserveringen veranderen</a>
                </nav>
            </div>
        </div>
    </section>
</header>

<main>
    <section class="agenda_content">
        <div class="room_info">
            <div class="room_header">Reserveren</div>

            <div class="room_stuff">
                <h2 class="heada">Zalen overzicht</h2>

                <!-- app.js vult deze lijst -->
                <div class="actual_rooms" id="roomsList"></div>

                <div class="actual_filter">Nieuwe reservering</div>

                <form method="post" action="reservations.create.php" class="reserve_form" id="reserveForm">
                    <input type="hidden" name="room_id" id="roomIdInput" value="">

                    <div class="selected_room_line">
                        Geselecteerde zaal: <strong id="selectedRoomName">Geen</strong>
                    </div>

                    <input type="text" name="title" id="titleInput" placeholder="Titel" required disabled>
                    <input type="datetime-local" name="start" id="startInput" required disabled>
                    <input type="datetime-local" name="end" id="endInput" required disabled>

                    <button type="submit" class="reserve_btn" id="reserveBtn" disabled>Reserveren</button>
                </form>
            </div>
        </div>

        <div class="agenda">
            <div class="filter_view">
                <button type="button" class="tab_btn" id="btnViewMonth">Maand</button>
                <button type="button" class="tab_btn is-active" id="btnViewWeek">Week</button>
                <button type="button" class="tab_btn" id="btnViewDay">Dag</button>
            </div>

            <div class="actual_agenda">
                <div id="calendar"></div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.CURRENT_USER_ID = <?= (int)$currentUserId ?>;
    window.ROOMS  = <?= json_encode($rooms, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    window.EVENTS = <?= json_encode($events, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
</script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="assets/app.js"></script>

</body>
</html>
