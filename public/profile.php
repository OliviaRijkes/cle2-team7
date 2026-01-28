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
mysqli_close($db);
if ($user['is_admin'] == 1) {
    $function = 'admin';
} elseif ($user['is_admin'] == 0) {
    $function = 'medewerker';
}
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
<body class="profile">
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <table>
        <tbody>
        <tr>
            <th>Voornaam</th>
            <td><?= $user['firstname'] ?></td>
        </tr>
        <tr>
            <th>Achternaam</th>
            <td><?= $user['lastname'] ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $user['email'] ?></td>
        </tr>
        <tr>
            <th>Functie</th>
            <td><?= $function ?></td>
        </tr>
        </tbody>
    </table>
    <button onclick="darkToggle()">darkmode</button>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
