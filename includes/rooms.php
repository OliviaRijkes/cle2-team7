<?php
// includes/rooms.php

function rooms_list(PDO $pdo): array {
    return $pdo->query("
        SELECT id, name, color
        FROM rooms
        WHERE is_active = 1
        ORDER BY id
    ")->fetchAll();
}
