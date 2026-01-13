<?php
session_start();
require __DIR__ . '/../includes/auth.php';
if ($_POST['submit']) {
    $email = htmlentities($_POST['email']);
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
        //db vars
        //email, pw, name?, others?
        $emailDb = mysqli_escape_string($db, $_POST['email']);
        $passwordDb = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //is deze persoon al geregistreerd?
        $query = "SELECT * FROM users
            WHERE email = '$emailDb'
            OR ";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
            //the person already exists
            $errors['email'] = "Iets ging mis";
        } else {
            $query = "INSERT INTO users () VALUES ()";
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