<?php
// require("controllers/process-delete-user.php");
require("includes/process.php");
if (empty($_SESSION["user_id"]) || isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "user") {
        header("location: includes/login.php");
    }
}
?>
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
        <title>Pesa Manager | Users</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper vw-100">
            <div class="row">
                <!-- Header -->
                <?php require("includes/header.php"); ?>
                <main class="col-lg-8 main py-1" id="main">
                    <div class="py-4 text-center">
                        <div class="container d-flex justify-content-center flex-column">
                            <?php if (isset($_POST["resetPassword"])) {
                        ?>
                            <div
                                class="d-flex justify-content-between alert alert-<?php echo $_SESSION["msg-type"]; ?> ">
                                <span>
                                    <?php
                                    echo $_SESSION["message"];
                                    unset($_SESSION["message"])
                                    ?>
                                </span>
                                <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                            </div>
                            <?php } ?>

                            <!-- Display Users in the table here -->
                            <div class="table-responsive">
                                <table
                                    class="table table-width table-bordered table-hover table-striped bg-light caption-top my-2 mt-3">
                                    <caption class="top text-light display-6 text-center">My Clients</caption>
                                    <thead class="bg-dark text-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Date Registered</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if (!$conn) {
                                        echo "Connection Error " . mysqli_connect_error();
                                    } else {
                                        $userIndex = 1;
                                        $sqlFetchUsers = "SELECT user_id, username, user_location, phone_number, role_type, date_registered FROM registration WHERE role_type = 'user'";
                                        $fetchUsersResult = mysqli_query($conn, $sqlFetchUsers);
                                        if (mysqli_num_rows($fetchUsersResult) > 0) {
                                            while ($singleUser = mysqli_fetch_assoc($fetchUsersResult)) {
                                    ?>
                                        <tr class="px-4">
                                            <th scope="row"><?php echo $userIndex++; ?></th>
                                            <td><?php echo $singleUser["username"]; ?></td>
                                            <td><?php echo $singleUser["user_location"]; ?></td>
                                            <td><?php echo $singleUser["phone_number"]; ?></td>
                                            <td><?php echo $singleUser["date_registered"]; ?></td>
                                            <td colspan="2" class="d-flex">
                                                <a href="view-user.php?view_user=<?php echo $singleUser["user_id"]; ?>"
                                                    title="View User"
                                                    class="d-flex mx-1 btn btn-info btn-sm text-light">
                                                    <i class="fas fa-eye me-1"></i><span
                                                        class="action-btn">View</span></a>
                                                <a href="edit-user.php?edit_user=<?php echo $singleUser["user_id"]; ?>"
                                                    title="Edit User"
                                                    class="d-flex mx-1 btn btn-warning btn-sm text-light">
                                                    <i class="fas fa-edit me-1"></i><span class="action-btn"
                                                        onclick=" return confirm('You are about to edit this user. Are you sure?')">Edit</span></a>
                                                <a href="users.php?delete_user=<?php echo $singleUser["user_id"]; ?>"
                                                    onclick=" return confirm('Are you sure you want to delete this user?')"
                                                    title="Delete User"
                                                    class="d-flex mx-1 btn btn-danger btn-sm text-light">
                                                    <i class="fas fa-trash-alt me-1"></i>
                                                    <span class="action-btn">Delete</span></a>
                                            </td>
                                            <?php  ?>
                                        </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <div class="my-2">No user registered on the system.</div>
                                        <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Footer -->
        <?php
    require("includes/footer.php")
    ?>
        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/scripts/hamburger.js"></script>
        <!-- <script src="assets/scripts/theme.js"></script> -->
        <script src="assets/scripts/app.js"></script>
    </body>
    </body>

</html>