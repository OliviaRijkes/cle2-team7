<?php
// includes/reservations.php

function reservation_save_from_post(PDO $pdo): void {

    // Controle: alleen doorgaan als dit een "save"-actie is
    if (($_POST['a'] ?? '') !== 's') {
        return; // geen reservering opslaan
    }

    // Invoer ophalen uit het formulier
    $room  = (int)($_POST['r'] ?? 0);
    $title = trim((string)($_POST['t'] ?? ''));
    $start = (string)($_POST['s'] ?? '');
    $end   = (string)($_POST['e'] ?? '');

    // Basisvalidatie: alles moet ingevuld zijn
    if ($room <= 0 || $title === '' || $start === '' || $end === '') {
        header('Location: /index.php');
        exit;
    }

    // Controle: eindtijd moet na starttijd liggen
    if (strtotime($end) <= strtotime($start)) {
        header('Location: /index.php');
        exit;
    }

    // Datum/tijd omzetten naar MySQL formaat
    // HTML input: 2026-01-13T10:00
    // MySQL:      2026-01-13 10:00:00
    $startDb = str_replace('T', ' ', $start) . ':00';
    $endDb   = str_replace('T', ' ', $end) . ':00';

    // Reservering opslaan in de database
    $stmt = $pdo->prepare("
        INSERT INTO reservations (room_id, title, start_datetime, end_datetime)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$room, $title, $startDb, $endDb]);

    // Redirect
    header('Location: /index.php');
    exit;
}

/**
 * Haalt alle reserveringen op uit de database en zet ze om
 */
function reservations_events(PDO $pdo): array {

    // Reserveringen ophalen + gekoppelde zaalgegevens
    $rows = $pdo->query("
        SELECT r.title, r.start_datetime, r.end_datetime,
               rm.name AS room_name, rm.color AS room_color
        FROM reservations r
        JOIN rooms rm ON rm.id = r.room_id
        ORDER BY r.start_datetime
    ")->fetchAll();

    $events = [];

    // Elke database-rij omzetten naar een event-array
    foreach ($rows as $x) {
        $events[] = [
            'title' => $x['title'] . ' (' . $x['room_name'] . ')',
            'start' => $x['start_datetime'],
            'end'   => $x['end_datetime'],
            'backgroundColor' => $x['room_color'],
            'borderColor' => $x['room_color'],
        ];
    }

    // Alle events teruggeven aan de pagina / frontend
    return $events;
}
