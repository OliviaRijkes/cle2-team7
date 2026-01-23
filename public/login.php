<?php
session_start();

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
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = htmlentities($user['email']);
                $_SESSION['firstname'] = htmlentities($user['firstname']);
                $_SESSION['lastname'] = htmlentities($user['lastname']);
                $_SESSION['is_admin'] = $user['is_admin'];
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
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>
<header>
    <section>
        <a href="header.php" class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </a>
        <div>
            <!--        Div flex placeholder-->
        </div>
    </section>
</header>
<main>
    <div class="login-container">
        <div class="login-medewerker">
            <div class="login-title">
                <h2>Inloggen medewerker:</h2>
            </div>
            <form action="" method="post">
                <div class="login-input-align">
                    <div class="login-email">
                        <label for="email">Email:</label>
                        <input type="text" name="email" id="email" value="<?= $email ?? '' ?>">
                    </div>
                    <div class="login-password">
                        <label for="password">Wachtwoord:</label>
                        <input type="password" name="password" id="password" value="<?= $password ?? '' ?>">
                    </div>
                </div>
                <div class="form-errors">
                    <p><?= $errors['email'] ?? '' ?></p>
                    <p><?= $errors['password'] ?? '' ?></p>
                </div>
                <div class="form-submit">
                    <input type="submit" name="submit" value="Log in">
                </div>
            </form>
        </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>