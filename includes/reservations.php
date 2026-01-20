<?php

function reservations_events($db): array
{
    // Huidige ingelogde gebruiker (0 als niet ingelogd)
    // Geeft "mijn" reserveringen een andere kleur.

    $currentUserId = (int)($_SESSION['id'] ?? 0);

    // SQL: haal alle reservations op + join naar rooms voor naam/kleur van de zaal
    // ORDER BY zorgt dat events op volgorde binnenkomen.

    $sql = "
        SELECT r.*, rm.name AS room_name, rm.color AS room_color
        FROM reservations r
        JOIN rooms rm ON rm.id = r.room_id
        ORDER BY r.start_datetime
    ";

    // Query uitvoeren
    $result = mysqli_query($db, $sql);

    // Als query faalt: lege array terug voorkomt warnings
    if (!$result) return [];

    // Hierin bouwen we de FullCalendar events
    $events = [];

    // Elke rij uit de DB omzetten naar event format
    while ($row = mysqli_fetch_assoc($result)) {
        // Check of deze reservation van de huidige gebruiker is
        $isMine = ((int)$row['user_id'] === $currentUserId);

        // DB datetime "YYYY-MM-DD HH:MM:SS" -> "YYYY-MM-DDTHH:MM:SS"
        // FullCalendar kan dit direct lezen.
        $startIso = str_replace(' ', 'T', $row['start_datetime']);
        $endIso   = str_replace(' ', 'T', $row['end_datetime']);

        // Event object voor FullCalendar
        $events[] = [
            // FullCalendar event id
            'id' => (int)$row['id'],

            // Titel die zichtbaar is in de agenda
            'title' => $row['title'],

            // Start/eind in ISO formaat
            'start' => $startIso,
            'end' => $endIso,

            // Kleur:
            // - als het "mijn" event is: vaste highlight kleur
            // - anders: kleur van de zaal (room_color uit rooms table)
            'backgroundColor' => $isMine ? '#44BFEA' : $row['room_color'],
            'borderColor' => $isMine ? '#44BFEA' : $row['room_color'],

            // Nog niet in gebruik
            'room_id' => (int)$row['room_id'],
            'user_id' => (int)$row['user_id']
        ];
    }

    // Geef alle events terug
    return $events;
}
