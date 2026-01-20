<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../includes/db.php';

$userId = (int)($_SESSION['id'] ?? 0);

$roomId = (int)($_POST['room_id'] ?? 0);
$title  = trim((string)($_POST['title'] ?? ''));
$start  = (string)($_POST['start'] ?? '');
$end    = (string)($_POST['end'] ?? '');

if ($userId <= 0 || $roomId <= 0 || $title === '' || $start === '' || $end === '') {
    header("Location: index.php");
    exit;
}

if (strtotime($end) <= strtotime($start)) {
    header("Location: index.php");
    exit;
}

$startDb = str_replace('T', ' ', $start) . ':00';
$endDb   = str_replace('T', ' ', $end) . ':00';

$stmt = mysqli_prepare(
    $db,
    "INSERT INTO reservations (room_id, user_id, title, start_datetime, end_datetime)
     VALUES (?, ?, ?, ?, ?)"
);

if (!$stmt) {
    // prepare mislukt (SQL fout / tabel bestaat niet / kolomnaam fout)
    die("Prepare failed: " . mysqli_error($db));
}

mysqli_stmt_bind_param($stmt, "iisss", $roomId, $userId, $title, $startDb, $endDb);

if (!mysqli_stmt_execute($stmt)) {
    // execute mislukt (foreign key fail, etc.)
    die("Execute failed: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);

header("Location: index.php");
exit;
