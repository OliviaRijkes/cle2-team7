<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: login.php');
}
//gebruiken we de naam van de persoon op de hoofdpagina? ->(welkom <=$firstname>)
//$firstname = $_SESSION['firstname']
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
<?php include('includes/nav.php'); ?>
<head>

</head>
<main>

</main>
<?php include('includes/footer.php'); ?>
</body>
</html>
