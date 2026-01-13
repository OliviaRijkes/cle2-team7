<?php
/** @var PDO $pdo */
require_once __DIR__ . '/../includes/db.php';

try {
    $count = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();

    echo "Database connect OK ✅<br>";
    echo "Aantal zalen: $count";
} catch (Exception $e) {
    http_response_code(500);
    echo "Database fout ❌<br>";
    echo htmlspecialchars($e->getMessage());
}
