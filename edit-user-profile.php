<?php
require("controllers/process-update-profile.php");
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
        <title>Pesa Manager | Update Profile</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php if (isset($_POST["updateUserProfile"])) {
                ?>
                    <div
                        class="d-flex justify-content-between w-50 mx-auto  alert alert-<?php echo $_SESSION['msg-type']; ?> ">
                        <span>
                            <?php
                            echo $_SESSION["message"];
                            unset($_SESSION["message"])
                            ?>
                        </span>
                        <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                    </div>
                    <?php } ?>
                    <?php
                if (isset($_SESSION["user_id"])) {
                    $activeUser = testData($_SESSION["user_id"]);
                    $sqlEditUserProfile = "SELECT username, user_location, phone_number FROM registration WHERE user_id = ?";
                    $stmt = $conn->prepare($sqlEditUserProfile);
                    $stmt->bind_param("i", $activeUser);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $userRowReturned =  $result->fetch_assoc();
                    if ($userRowReturned) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">Edit User Profile</h5>
                            </div>
                            <div class="modal-body">
                                <form action="edit-user-profile.php" method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="item">Username</label>
                                        <input type="text" class="form-control" id="item" name="updateUsername"
                                            placeholder="Username"
                                            value=" <?php echo $userRowReturned["username"] ?> " />
                                        <span class="text-danger"><?php echo $updateUsernameError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="expenseAmount">Phone Number</label>
                                        <input inputmode="numeric" class="form-control" id="updatePhoneNumber"
                                            name="updatePhoneNumber" placeholder="Your phone number"
                                            value=" <?php echo $userRowReturned["phone_number"] ?> " />
                                        <span class="text-danger"><?php echo $updatePhoneNumberError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="description">Location</label>
                                        <input type="text" class="form-control" id="updateUserLocation"
                                            name="updateUserLocation" placeholder="Your location"
                                            value=" <?php echo $userRowReturned["user_location"] ?> " />
                                        <span class="text-danger"><?php echo $updateUserLocationError; ?></span>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="homepage.php" class="btn btn-secondary">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="updateUserProfile"
                                            name="updateUserProfile">Save
                                            Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>

                </main>
            </div>
        </div>

        <!-- Footer -->
        <?php
    require("includes/footer.php");
    ?>
        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/scripts/hamburger.js"></script>
        <!-- <script src="assets/scripts/theme.js"></script> -->
        <script src="assets/scripts/app.js"></script>
    </body>

</html>