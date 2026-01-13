<?php
/** @var PDO $pdo */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/rooms.php';
require_once __DIR__ . '/../includes/reservations.php';

// Backend staat klaar, maar wordt nog niet gebruikt in UI
$rooms  = rooms_list($pdo);
$events = reservations_events($pdo);
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