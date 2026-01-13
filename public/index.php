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

<?php include __DIR__ . '/../includes/nav.php'; ?>

<main>

</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
