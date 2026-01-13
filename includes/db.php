<?php
// includes/db.php



// Database-instellingen
$host       = 'localhost';
$dbuser     = 'root';
$dbpassword = '';
$database   = 'bouw_reserveringen';

// Maak verbinding met de database
$db = mysqli_connect($host, $dbuser, $dbpassword, $database);

// Controleer of de verbinding is gelukt
if (!$db) {
    // HTTP 500 foutmelding bij verbindingsprobleem
    http_response_code(500);
    echo "Database fout! Uh oh<br>";
    echo htmlspecialchars(mysqli_connect_error());
    exit;
}

// Zorg dat tekens correct worden opgeslagen
mysqli_set_charset($db, 'utf8mb4');
