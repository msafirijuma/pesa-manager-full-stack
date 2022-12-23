<?php require("controllers/process-password-reset.php"); ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="assets/styles/style.css" />
        <link rel="stylesheet" href="assets/styles/bootstrap/bootstrap.min.css" />
        <title>Pesa Manager | Reset Password</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
            integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
            crossorigin="anonymous" />
    </head>

    <body>
        <div class="bg-img-wrapper bg-img-wrapper-sm vh-100">
            <main class="main" id="main">
                <div class="p-2">
                    <a href="includes/login.php" class="btn btn-primary">Back</a>
                </div>
                <h2 id="signup-tab" class="text-center pt-5 mb-4">
                    Reset Your Password
                </h2>
                <div class="tab-pane tab-pane-mobile mx-auto" id="login">
                    <?php if (isset($_POST["resetPassword"])) {
                ?>
                    <div class="d-flex justify-content-between alert alert-<?php echo $_SESSION["msg-type"]; ?> ">
                        <span>
                            <?php
                            echo $_SESSION["message"];
                            unset($_SESSION["message"])
                            ?>
                        </span>
                        <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>
                    <!-- Reset Password Form -->
                    <form action="reset-password.php" method="POST" class="login-form">
                        <div class="form-group my-3">
                            <label for="email">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-message" id="hamburgerIcon"></i></span>
                                <input type="email" class="form-control" name="emailRequestReset" id="emailRequestReset"
                                    placeholder="Enter email address" value="<?php echo $emailRequestReset ?>" />
                            </div>
                            <span class="text-danger"><?php echo $emailRequestResetError; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="resetPassword">
                            Reset Password
                        </button>
                    </form>
                </div>
            </main>
        </div>
        <!-- Footer -->
        <?php
    require("includes/footer.php");
    ?>
        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/scripts/app.js"></script>
    </body>

</html>