<?php
session_start();
//go away peasant \owo/
if ($_SESSION['is_admin']!= 1){
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    //html & val vars
    $email = htmlentities($_POST['email']);
    $password = $_POST['password'];
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    if (isset($_POST['admin'])){
        $admin = $_POST["admin"];
    } else{
        $admin = 0;
    }
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
    if ($admin != 0) if ($admin != 1){
        $errors['admin'] = "Asshole allert";
    }
    print_r($admin);

    if (empty($errors)) {
        print_r('no errors');
        //db vars
        require_once '../includes/db.php';
        $emailDb = mysqli_escape_string($db, $_POST['email']);
        $passwordDb = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $firstnameDb = mysqli_escape_string($db, $_POST['firstname']);
        $lastnameDb = mysqli_escape_string($db, $_POST['lastname']);
        $adminDb = mysqli_escape_string($db, $admin);
        //does this person already exist?
        $query = "SELECT firstname, lastname FROM users WHERE email='$emailDb'";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);
        print_r($user);

        if (empty($user)) {
            $query = "INSERT INTO users (email, password, firstname, lastname, is_admin) VALUES ('$emailDb', '$passwordDb', '$firstnameDb', '$lastnameDb', '$adminDb')";
            $result = mysqli_query($db, $query);
            if (!$result) {
                $errors['password'] = "Er is een fout opgetreden";
            } else {
                // login page
                header("Location: login.php");
            }
        } else{
            $errors['email'] = $user['firstname']." ".$user['lastname']." staat al onder dit email address geregistreerd";
        }
        //INSERT user
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
    <link rel="stylesheet" href="assets/app.css">
    <script defer src="assets/darkmode.js"></script>
</head>
<body class="register">
<?php include __DIR__ . '/../includes/header.php'; ?>
<main>
    <h2>Registreer Medewerker/admin</h2>
    <form action="" method="post">
        <div class="label-input">
            <label for="email">email</label>
            <div class="input-error">
                <input type="text" name="email" id="email" value="<?= $email ?? '' ?>">
                <p><?= $errors['email'] ?? '' ?></p>
            </div>
        </div>
        <div class="label-input">
            <label for="password">password</label>
            <div class="input-error">
                <input type="password" name="password" id="password">
                <p><?= $errors['password'] ?? '' ?></p>
            </div>
        </div>
        <div class="label-input">
            <label for="firstname">firstname</label>
            <div class="input-error">
                <input type="text" name="firstname" id="firstname" value="<?= $firstname ?? '' ?>">
                <p><?= $errors['firstname'] ?? '' ?></p>
            </div>
        </div>
        <div class="label-input">
            <label for="lastname">lastname</label>
            <div class="input-error">
                <input type="text" name="lastname" id="lastname" value="<?= $lastname ?? '' ?>">
                <p><?= $errors['lastname'] ?? '' ?></p>
            </div>
        </div>
        <div class="label-input">
            <label for="admin">admin</label>
            <div class="input-error">
                <input type="checkbox" name="admin" id="admin" value="1">
                <p><?= $errors['admin'] ?? '' ?></p>
            </div>
        </div>
        <button type="submit" name="submit">registeer medewerker/admin</button>
    </form>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
