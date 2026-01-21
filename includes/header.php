<header>
    <section>
        <a href="header.php" class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </a>
        <div class="dropdown_in_header">
            <div class="dropdown">
                <button class="dropbtn"></button> <!-- Hier komt nog een foto -->
                <nav class="dropdown-content">
                    <a href="profile.php">Profiel</a>
                    <a href="index.php">Agenda</a>
                    <a href="details.php?id=<?=$_SESSION['id']?>">Mijn reserveringen</a>
                    <a href="">Reserveringen veranderen</a>
                    <a href="logout.php">Uitloggen</a>
                </nav>
            </div>
        </div>
    </section>
</header>