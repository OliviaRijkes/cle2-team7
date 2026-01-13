<?php
// includes/db.php


// Database-instellingen
$host = 'localhost';               // Database server
$db   = 'bouw_reserveringen';      // Database naam
$user = 'root';                    // Gebruikersnaam
$pass = '';                        // Wachtwoord (leeg voor lokaal)

// Probeer verbinding te maken met de database
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4", // DSN
        $user,
        $pass,
        [
            // Gooi exceptions bij fouten (beter debuggen)
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            // Resultaten standaard als associatieve array
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (Exception $e) {
    // Als de verbinding faalt:
    // - stuur een HTTP 500 error
    // - toon een foutmelding
    http_response_code(500);
    echo "Database fout ❌<br>";
    echo htmlspecialchars($e->getMessage());
    exit;
}
