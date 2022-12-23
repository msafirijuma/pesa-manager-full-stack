<?php
require("includes/process.php");
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
        <title>Pesa Manager | View Users</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php
                if (isset($_GET["view_user"]) && isset($_SESSION["user_id"]) && $conn) {
                    $loggedInUser = $_SESSION["user_id"];
                    $fetchedViewUserId = testData($_GET["view_user"]);
                    $fetchedViewUserId = filter_var($fetchedViewUserId, FILTER_VALIDATE_INT);
                    $sqlFetchViewUser = "SELECT username, email, user_location, phone_number, role_type, date_registered FROM registration WHERE user_id = '$fetchedViewUserId'";
                    $fetchedViewUser = mysqli_query($conn, $sqlFetchViewUser);

                    if (mysqli_num_rows($fetchedViewUser) === 1) {
                        while ($rowUser = mysqli_fetch_assoc($fetchedViewUser)) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">Client Details</h5>
                            </div>
                            <div class="modal-body">
                                <form action="view-users.php?view_user= <?php echo $rowUser["user_id"]; ?>"
                                    method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control"
                                            value=" <?php echo $rowUser["username"]; ?> " readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control" value=" <?php echo $rowUser["email"]; ?> "
                                            readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="location">Location</label>
                                        >
                                        <input class="form-control" value=" <?php echo $rowUser["user_location"]; ?> "
                                            readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <input class="form-control"
                                            value=" <?php echo date($rowUser["phone_number"]); ?> " readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="role">Role</label>
                                        <input class="form-control" value=" <?php echo $rowUser["role_type"]; ?> "
                                            readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="phone">Date Registered</label>
                                        <input class="form-control"
                                            value=" <?php echo date($rowUser["date_registered"]); ?> " readonly />
                                    </div>
                                    <div class="modal-footer">
                                        <a href="users.php" class="btn btn-sm d-block btn-secondary" id="updaterevenue"
                                            name="updaterevenue">OK</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
        <script src="assets/scripts/userChoiceType.js"></script>
        <!-- <script src="assets/scripts/theme.js"></script> -->
        <script src="assets/scripts/app.js"></script>
    </body>

</html>