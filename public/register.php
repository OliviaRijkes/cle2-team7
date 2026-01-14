<?php
session_start();
if (isset($_POST['submit'])) {
    //html & val vars
    $email = htmlentities($_POST['email']);
    $password = $_POST['password'];
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $admin = htmlentities($_POST['admin']);
    //validate
    if ($email == "") {
        $errors['email'] = "Voer een email in";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Ongeldig e-mailadres";
    }
    if ($password == "") {
        $errors['password'] = "Voer een wachtwoord in";
    }
    if ($firstname == "") {
        $errors['firstname'] = "Voer een voornaam in";
    }
    if ($lastname == "") {
        $errors['lastname'] = "Voer een achternaam in";
    }
    if ($admin == "") {
        $errors['admin'] = "Voer een admin in";
    } elseif (!is_numeric($admin)) {
        $errors['admin'] = "admin is een nummer: 1(wel) of 0(niet)";
    } elseif ($admin < 0 || $admin > 1){
        $errors['admin'] = "admin is 1(wel) of 0(niet)";
    }
    if (empty($errors)) {
        print_r('no errors');
        //db vars
        require_once '../includes/db.php';
        $emailDb = mysqli_escape_string($db, $_POST['email']);
        $passwordDb = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $firstnameDb = mysqli_escape_string($db, $_POST['firstname']);
        $lastnameDb = mysqli_escape_string($db, $_POST['lastname']);
        $adminDb = mysqli_escape_string($db, $_POST['admin']);
        //INSERT user
        $query = "INSERT INTO users (email, password, firstname, lastname, is_admin) VALUES ('$emailDb', '$passwordDb', '$firstnameDb', '$lastnameDb', '$adminDb')";
        $result = mysqli_query($db, $query);
        if (!$result) {
            $errors['password'] = "Er is een fout opgetreden";
        } else {
            // login page
            header("Location: login.php");
        }
        mysqli_close($db);
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
<form action="" method="post">
    <div>
        <label for="email">email</label>
        <input type="text" name="email" id="email" value="<?= $email ?? '' ?>">
        <p><?= $errors['email'] ?? '' ?></p>
    </div>
    <div>
        <label for="password">password</label>
        <input type="password" name="password" id="password">
        <p><?= $errors['password'] ?? '' ?></p>
    </div>
    <div>
        <label for="firstname">firstname</label>
        <input type="text" name="firstname" id="firstname" value="<?= $firstname ?? '' ?>">
        <p><?= $errors['firstname'] ?? '' ?></p>
    </div>
    <div>
        <label for="lastname">lastname</label>
        <input type="text" name="lastname" id="lastname" value="<?= $lastname ?? '' ?>">
        <p><?= $errors['lastname'] ?? '' ?></p>
    </div>
    <div>
        <label for="admin">admin</label>
        <input type="text" name="admin" id="admin" value="<?= $admin ?? '' ?>">
        <p><?= $errors['admin'] ?? '' ?></p>
    </div>
    <button type="submit" name="submit">registeer medewerker/admin</button>
</form>
</body>
</html>
