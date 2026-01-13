<?php
session_start();
require __DIR__ . '/../includes/auth.php';

if (isset($_POST['submit'])) {
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
        //db
        require_once __DIR__ . '/../includes/db.php';
        $emailDb = mysqli_escape_string($db, $_POST['email']);
        $passwordDb = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "SELECT * FROM users WHERE email = '$emailDb'";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                //the needed data for site exploration and authorization
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['admin'] = $user['admin'];
                //index
                header('Location: index.php');
            } else {
                $errors['password'] = "Probeer opnieuw of registreer";
            }
        } else {
            $errors['password'] = "Probeer opnieuw of registreer";
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
    <title>Login</title>
</head>
<body>
<form action="" method="post">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="<?=$email ??''?>">
    <p>emailerr:<?=$errors['email']??''?></p>
    <label for="password">Wachtwoord</label>
    <input type="text" name="password" id="password" value="<?=$password ??''?>">
    <p>pwerr:</p>
    <button type="submit">Log in</button>
</form>
</body>
</html>