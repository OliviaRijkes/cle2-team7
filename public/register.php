<?php
session_start();
if ($_POST['submit']) {
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    //validate
    if ($email == "") {
        $errors['email'] = "Voer een email in";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Ongeldige e-mailadres";
    }
    if ($_POST['password'] == "") {
        $errors['password'] = "Voer een wachtwoord in";
    }
    if (!isset($errors)) {
        //db
        require_once __DIR__ . '/../includes/db.php';
        //db vars
        $emailDb = mysqli_escape_string($db, $_POST['email']);
        $passwordDb = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $firstnameDb = mysqli_escape_string($db, $_POST['firstname']);
        $lastnameDb = mysqli_escape_string($db, $_POST['lastname']);
        $adminDb = mysqli_escape_string($db, $_POST['admin']);
        //is deze persoon al geregistreerd? (later)
        $query = "INSERT INTO users (email, password, firstname, lastname, is_admin)
            VALUES ()";
        $result = mysqli_query($db, $query);
        if (!$result) {
            $errors['password'] = "Er is een fout opgetreden";
        } else {
            // login page
            header("Location: login.php");
        }
    }
}
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registreer</title>
</head>
<body>

</body>
</html>
