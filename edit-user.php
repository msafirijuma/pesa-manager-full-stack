<?php
require("controllers/process-edit-user.php");
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
        <title>Pesa Manager | Edit User</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php if (isset($_POST["updateUser"])) {
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
                if (isset($_GET["edit_user"]) && isset($_SESSION["user_id"]) && $conn) {
                    $loggedInUser = $_SESSION["user_id"];
                    $fetchedUserId = $_GET["edit_user"];
                    $sqlFetchEditUser = "SELECT user_id, username, role_type FROM registration WHERE user_id = '$fetchedUserId' LIMIT 1 ";
                    $fetchedEditUserResult = mysqli_query($conn, $sqlFetchEditUser);

                    if (mysqli_num_rows($fetchedEditUserResult) == 1) {
                        while ($userRow = mysqli_fetch_assoc($fetchedEditUserResult)) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable pt-5">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">Edit User Details</h5>
                            </div>
                            <div class="modal-body">
                                <form action="edit-user.php?edit_user= <?php echo $userRow["user_id"]; ?>"
                                    method="POST">
                                    <div class="form-group my-2">
                                        <label for="" class="form-label">Selected User</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $userRow["username"]; ?>" readonly>
                                    </div>
                                    <div class="form-group my-2">
                                        <label for="" class="form-label"> Current Role</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $userRow["role_type"]; ?>" readonly>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="userAmount">New Role</label>
                                        <select name="roleType" id="roleType" class="form-select w-100">
                                            <option value="default" selected>Assign New Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                        <span class="text-danger"><?php echo $roleTypeError; ?></span>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="users.php" class="btn btn-secondary" name="btn_close">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="updateUser" name="updateUser"
                                            onclick="return confirm('Assign new role to this user. Are you sure?')">Save
                                            Changes</button>
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