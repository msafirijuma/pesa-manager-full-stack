<?php
if (isset($_SESSION["role"])) {
    header("includes/login.php");
}
?>
<header class="col-lg-4 header navbar navbar-light bg-primary flex-row flex-md-column px-2 px-sm-3 py-md-0 pt-md-1"
    id="header">
    <h1 class="brand-name display-6 ps-2">Pesa Manager</h1>
    <nav class="nav-menu bg-primary d-flex justify-content-center pt-3">
        <ul class="nav-group">
            <li class="nav-item">
                <a href="homepage.php" class="text-light nav-link">
                    <i class="fas fa-home" id="hamburgerIcon"></i>
                    Home</a>
            </li>
            <li class="nav-item">
                <a href="expenditures.php" class="text-light nav-link">
                    <i class="fas fa-donate" id="hamburgerIcon"></i>
                    Expenditures</a>
            </li>
            <li class="nav-item">
                <a href="revenues.php" class="text-light nav-link">
                    <i class="fas fa-wallet" id="hamburgerIcon"></i>
                    Revenues</a>
            </li>
            <?php
            if ($_SESSION["role"] == "admin") : ?>
            <li class="nav-item">
                <a href="users.php" class="text-light nav-link">
                    <i class="fas fa-user me-1"></i> Users</a>
            </li>
            <?php endif ?>
            <li class="dropdown nav-item pt-2">
                <button class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user" id="hamburgerIcon"></i> Account
                </button>
                <ul class="dropdown-menu p-2">
                    <li class="nav-item">
                        <a href="edit-user-profile.php" class="nav-link-account text-dark"
                            onclick="return confirm('You are about to edit your details. Are you sure?')">
                            <i class="fas fa-user-edit" id="hamburgerIcon"></i> Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="change-password.php" class="nav-link-account text-dark"
                            onclick="return confirm('You are about to change your password. Are you sure?')">
                            <i class="fas fa-user-lock" id="hamburgerIcon"></i> Change PIN</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="text-light nav-link">
                    <span class="theme-mode" id="themeToggler" title="Change theme">
                        <i class="fas fa-moon" id="themeIcon"></i> Theme
                    </span>
                </a>
            </li>
            <hr class="d-none d-lg-block links-divider mt-4">
            <li class="nav-item mt-lg-1 logout-link">
                <a href="index.php?logout='1'" class="text-light nav-link">
                    <i class="fas fa-sign-out"></i> Logout</a>
            </li>
        </ul>
    </nav>
    <div class="hamburger">
        <i class="fas fa-hamburger" id="hamburgerIcon">@</i>
    </div>
</header>