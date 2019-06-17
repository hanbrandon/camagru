<nav>
    <ul>
        <div class="logo">
            <li>
                <a href="/">
                    <i class="fas fa-camera-retro"></i>Camagru</a>
            </li>
        </div>
        <div class="right_nav">
            <li>
                <a href="?id=upload.php">
                    <i class="fas fa-camera"></i>
                </a>
            </li>
            <li>
                <a href="?id=my_account.php">
                    <i class="fas fa-user"></i>
                </a>
            </li>
            <?php
            if (isset($_SESSION['logged_in']))
            {               
            ?>
            <li>
                <a href="/functions/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
            <?php
            }
            ?>
        </div>
    </ul>
</nav>