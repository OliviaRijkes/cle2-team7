<?php
// public/db_test.php

require_once __DIR__ . '/../includes/db.php';

// Test of de databaseverbinding werkt
if (!$db) {
    http_response_code(500);
    echo "Database fout ";
    exit;
}

// Query om het aantal zalen te tellen
$result = mysqli_query($db, "SELECT COUNT(*) AS total FROM rooms");

if (!$result) {
    http_response_code(500);
    echo "Query fout ";
    exit;
}

$row = mysqli_fetch_assoc($result);

echo "Database connect OK <br>";
echo "Aantal zalen: " . $row['total'];
