<?php
// Start de sessie zodat we toegang hebben tot ingelogde gebruiker
session_start();

// Check of de gebruiker is ingelogd (id in session)
// Zo niet: terug naar loginpagina
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

// Database connectie
require_once __DIR__ . '/../includes/db.php';


// Ingelogde gebruiker (uit session)
$userId = (int)($_SESSION['id'] ?? 0);

// Gegevens uit het formulier (POST)
$roomId = (int)($_POST['room_id'] ?? 0);
$title  = trim((string)($_POST['title'] ?? ''));
$start  = (string)($_POST['start'] ?? '');
$end    = (string)($_POST['end'] ?? '');

// Validatie: alles moet ingevuld zijn en geldige IDs hebben
if ($userId <= 0 || $roomId <= 0 || $title === '' || $start === '' || $end === '') {
    header("Location: index.php");
    exit;
}

// Validatie: eindtijd moet na starttijd liggen
if (strtotime($end) <= strtotime($start)) {
    header("Location: index.php");
    exit;
}

// HTML datetime-local omzetten naar MySQL formaat
$startDb = str_replace('T', ' ', $start) . ':00';
$endDb   = str_replace('T', ' ', $end) . ':00';

// SQL-injectie te voorkomen
$stmt = mysqli_prepare(
    $db,
    "INSERT INTO reservations (room_id, user_id, title, start_datetime, end_datetime)
     VALUES (?, ?, ?, ?, ?)"
);


// Koppel PHP-variabelen aan de placeholders
mysqli_stmt_bind_param(
    $stmt,
    "iisss",
    $roomId,
    $userId,
    $title,
    $startDb,
    $endDb
);

// Sluit de statement af
mysqli_stmt_close($stmt);

// Na opslaan altijd terug naar index (agenda-overzicht)
header("Location: index.php");
exit;
