<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" data-toggle="collapse" data-target="#MainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="MainNav">
            <a href="#" class="navbar-brand"><?php echo($page_title); ?></a>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Tests</a>
                    <div class="dropdown-menu">
                        <a href="bigFive.php" class="dropdown-item">Test 1</a>
                        <a href="personality.php" class="dropdown-item">Test 2</a>
                        <a href="optimism.php" class="dropdown-item">Test 3</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="logout.php">Logout</a>
        </div>
    </div>
</nav>