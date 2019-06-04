<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" data-toggle="collapse" data-target="#MainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="MainNav">
            <a href="#" class="navbar-brand"><?php echo($page_title); ?></a>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Select a Test</a>
                    <div class="dropdown-menu">
                        <a href="bigFive.php" class="dropdown-item">Big Five</a>
                        <a href="personality.php" class="dropdown-item">Personality</a>
                        <a href="optimism.php" class="dropdown-item">Optimism</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="navbar-nav">
            <a class="nav-item nav-link">Time remaining: <span id="time">00:00</span></a>
        </div>
        <div class="navbar-nav">
            <span style="color:rgba(255,255,255,.5);">Welcome <?php echo $_SESSION['first_name'];?>,</span> 
        </div>
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="logout.php">Logout</a>
        </div>
    </div>
</nav>