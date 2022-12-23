<?php require("includes/process.php") ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="assets/styles/style.css" />
        <link rel="stylesheet" href="assets/styles/bootstrap/bootstrap.min.css" />
        <title>Pesa Manager | Register</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
            integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
            crossorigin="anonymous" />
    </head>

    <body>
        <div class="bg-img-wrapper bg-img-wrapper-sm">
            <h1 class="brand-name display-6 text-center ps-2 pt-4">Pesa Manager</h1>
            <main class="main" id="main">
                <!-- Hero Section -->
                <div class="jumbotron pt-4 pb-3 text-center text-md-start">
                    <div class="container d-flex justify-content-center flex-column align-items-center">
                        <h2 class="hero-title">WELCOME TO PESA MANAGER</h2>
                        <p class="hero-text">
                            Manage your expenses and revenues all in one app.
                        </p>
                    </div>
                </div>

                <!-- Sign Up Section -->
                <h2 class="text-center mb-4" id="signup-tab">
                    Create Account
                </h2>
                <?php include("includes/register.php") ?>
            </main>
        </div>

        <!-- Footer -->
        <?php
    require("includes/footer.php")
    ?>
        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>

</html>