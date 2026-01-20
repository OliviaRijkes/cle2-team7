<?php
// includes/rooms.php (mysqli)

function rooms_list($db): array
{
    $sql = "
        SELECT id, name, color, capacity
        FROM rooms
        WHERE is_active = 1
        ORDER BY id
    ";

    $result = mysqli_query($db, $sql);
    if (!$result) {
        return [];
    }

    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }

    mysqli_free_result($result);
    return $rooms;
}
