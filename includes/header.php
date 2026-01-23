<header>
    <section>
        <a href="index.php" class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </a>
        <div class="dropdown_in_header">
            <div class="dropdown">
                <button class="dropbtn"></button> <!-- Hier komt nog een foto -->
                <nav class="dropdown-content">
                    <a href="profile.php">Profiel</a>
                    <a href="logout.php">Uitloggen</a>
                    <a href="index.php">Agenda</a>
                    <a href="details.php">Mijn reserveringen</a>
                    <a href="">Reserveringen veranderen</a>
                    <?php if ($_SESSION['is_admin'] == 1) { ?>
                        <a href="register.php">registreer medewerker/admin</a>
                    <?php } ?>
                </nav>
            </div>
        </div>
    </section>
</header>