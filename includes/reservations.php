<?php
// includes/reservations.php (mysqli)

function reservation_save_from_post($db): void
{
    // Alleen doorgaan als dit een save-actie is
    if (($_POST['a'] ?? '') !== 's') {
        return;
    }

    // Invoer ophalen
    $room  = (int)($_POST['r'] ?? 0);
    $title = trim((string)($_POST['t'] ?? ''));
    $start = (string)($_POST['s'] ?? '');
    $end   = (string)($_POST['e'] ?? '');

    // Basisvalidatie
    if ($room <= 0 || $title === '' || $start === '' || $end === '') {
        header('Location: /index.php');
        exit;
    }

    if (strtotime($end) <= strtotime($start)) {
        header('Location: /index.php');
        exit;
    }

    // datetime-local -> MySQL
    $startDb = str_replace('T', ' ', $start) . ':00';
    $endDb   = str_replace('T', ' ', $end) . ':00';

    // Prepared statement
    $stmt = mysqli_prepare($db, "
        INSERT INTO reservations (room_id, title, start_datetime, end_datetime)
        VALUES (?, ?, ?, ?)
    ");

    if (!$stmt) {
        header('Location: /index.php');
        exit;
    }

    // i = int, s = string
    mysqli_stmt_bind_param($stmt, "isss", $room, $title, $startDb, $endDb);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect
    header('Location: /index.php');
    exit;
}


function reservations_events($db): array
{
    $sql = "
        SELECT r.title, r.start_datetime, r.end_datetime,
               rm.name AS room_name, rm.color AS room_color
        FROM reservations r
        JOIN rooms rm ON rm.id = r.room_id
        ORDER BY r.start_datetime
    ";

    $result = mysqli_query($db, $sql);
    if (!$result) {
        return [];
    }

    $events = [];
    while ($x = mysqli_fetch_assoc($result)) {
        $events[] = [
            'title' => $x['title'] . ' (' . $x['room_name'] . ')',
            'start' => $x['start_datetime'],
            'end'   => $x['end_datetime'],
            'backgroundColor' => $x['room_color'],
            'borderColor' => $x['room_color'],
        ];
    }

    mysqli_free_result($result);
    return $events;
}
