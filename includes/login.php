<?php require("process.php"); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../assets/styles/style.css" />
        <link rel="stylesheet" href="../assets/styles/bootstrap/bootstrap.min.css" />
        <title>Pesa Manager | Login</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
            integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
            crossorigin="anonymous" />
    </head>

    <body>
        <div class="bg-img-wrapper bg-img-wrapper-sm">
            <h1 class="brand-name display-6 ps-2 pt-4 text-center">Pesa Manager</h1>
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

                <!-- Sign In Section -->
                <h2 id="signup-tab" class="text-center mb-4">
                    Login
                </h2>
                <div class="tab-pane tab-pane-mobile mx-auto" id="login">
                    <?php if (isset($_POST["login"])) {
                ?>
                    <div class="d-flex justify-content-between  alert alert-<?php echo $_SESSION['msg-type']; ?> ">
                        <span>
                            <?php
                            echo $_SESSION["message"];
                            unset($_SESSION["message"]);
                            ?>
                        </span>
                        <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>
                    <!-- Login Form -->
                    <form action="login.php" method="POST" class="login-form">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="emailLogin" id="emailLogin"
                                    placeholder="Enter email address" value="<?php echo $emailLogin ?>" />
                            </div>
                            <span class="text-danger"><?php echo $emailLoginError; ?></span>
                        </div>
                        <div class="form-group my-2">
                            <label for="passowrd">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="passwordLogin" id="passowrdLogin"
                                    placeholder="Enter Password" />
                            </div>
                            <span class="text-danger"><?php echo $passwordLoginError; ?></span>
                        </div>
                        <button type="submit" class="btnLogin btn btn-primary" name="login">
                            Login
                        </button>
                        <div class="lead d-md-flex justify-content-between align-items-baseline my-2">
                            <div class="link-container  mt-2">Not yet a member? <a
                                    class="m-1 register-link text-primary" href="../index.php">Sign up</a>
                            </div>
                            <div>
                                <a href="../reset-password.php" class="text-decoration-none text-danger">forgot
                                    password?</a>
                            </div>
                        </div>
                        <div class="text-center my-2 separator-icon">----- OR -----</div>
                        <div class="btn_google btn btn-primary w-100">
                            <i class="fab fa-google me-1"></i> Login with Google
                        </div>
                    </form>
                </div>
            </main>
        </div>
        <!-- Footer -->
        <?php
    require("footer.php")
    ?>
        <script src="../assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/scripts/app.js"></script>
    </body>

</html>