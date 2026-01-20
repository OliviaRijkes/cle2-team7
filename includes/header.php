<header>
    <section>
        <div class="logo_in_header">
            <img class="logo" src="Images/Logo-BMN-De-Klerk.jpg" alt="Logo BMN de klerk">
        </div>
        <div class="dropdown_in_header">
            <div class="dropdown">
                <button class="dropbtn"></button> <!-- Hier komt nog een foto -->
                <nav class="dropdown-content">
                    <a href="logout.php">Uitloggen</a>
                    <a href="details.php?id=<?=$_SESSION['id']?>">Mijn reserveringen</a>
                    <a href="">Reserveringen veranderen</a>
                </nav>
            </div>
        </div>
    </section>
</header>