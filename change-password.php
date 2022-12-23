<?php
require("controllers/process-change-password.php");
if (empty($_SESSION["user_id"])) {
    header("location: includes/login.php");
} ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="assets/styles/style.css" />
        <link rel="stylesheet" href="assets/styles/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
            integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
            crossorigin="anonymous" />
        <title>Pesa Manager | Change Password</title>
    </head>

    <body>
        <div class="container-fluid  bg-img-wrapper bg-img-wrapper-sm vh-100">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-3" id="main">
                    <?php if (isset($_POST["updatePassword"])) {
                ?>
                    <div
                        class="d-flex justify-content-between w-100 w-md-50 mx-auto alert alert-<?php echo $_SESSION['msg-type']; ?> ">
                        <span>
                            <?php
                            echo $_SESSION["message"];
                            unset($_SESSION["message"])
                            ?>
                        </span>
                        <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">Change Password</h5>
                            </div>
                            <div class="modal-body">
                                <form action="change-password.php" method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="item">Old Password</label>
                                        <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                                            placeholder="Old Password" />
                                        <span class="text-danger"><?php echo $oldPasswordError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="expenseAmount">New Password</label>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword"
                                            placeholder="New Password" />
                                        <span class="text-danger"><?php echo $newPasswordError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="description">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirmNewPassword"
                                            name="confirmNewPassword" placeholder="Confirm New Password" />
                                        <span class="text-danger"><?php echo $confirmNewPasswordError; ?></span>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="homepage.php" class="btn btn-secondary">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="updatePassword"
                                            name="updatePassword">Save
                                            Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        <!-- Footer -->
        <?php
    require("includes/footer.php");
    ?>
        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/scripts/hamburger.js"></script>
        <script src="assets/scripts/userChoiceType.js"></script>
        <!-- <script src="assets/scripts/theme.js"></script> -->
        <script src="assets/scripts/app.js"></script>
    </body>

</html>