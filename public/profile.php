<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["id"];
require_once __DIR__ . '/../includes/db.php';
$query = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
print_r($user);
print_r($_SESSION);
mysqli_close($db);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profiel</title>
    <link rel="stylesheet" href="assets/app.css">
    <script defer src="assets/darkmode.js"></script>
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>

<button onclick="darkToggle()">darkmode</button>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
