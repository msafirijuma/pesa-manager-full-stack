<?php
require("controllers/process-edit-revenue.php");
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
        <title>Pesa Manager | Edit Revenue</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php if (isset($_POST["updateRevenue"])) {
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
                if (isset($_GET["edit_revenue"]) && isset($_SESSION["user_id"]) && $conn) {
                    $loggedInUser = $_SESSION["user_id"];
                    $fetchedRevenueId = $_GET["edit_revenue"];
                    $sqlFetchEditRevenue = "SELECT revenues.revenue_id,revenues.item, revenues.amount, revenues.revenue_description FROM revenues INNER JOIN registration ON revenues.user_id = registration.user_id WHERE revenues.user_id = '$loggedInUser' AND revenues.revenue_id = '$fetchedRevenueId'";
                    $fetchedEditRevenueResult = mysqli_query($conn, $sqlFetchEditRevenue);

                    if (mysqli_num_rows($fetchedEditRevenueResult) === 1) {
                        while ($revenueRowReturned = mysqli_fetch_assoc($fetchedEditRevenueResult)) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">Edit Revenue Record</h5>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="edit-revenue.php?edit_revenue= <?php echo $revenueRowReturned["revenue_id"]; ?>"
                                    method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="item">Item</label>
                                        <input type="text" class="form-control" id="item" name="editRevenueItem"
                                            placeholder="Enter an item"
                                            value=" <?php echo $revenueRowReturned["item"] ?> " />
                                        <span class="text-danger"><?php echo $editRevenueItemError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="revenueAmount">Amount</label>
                                        <input inputmode="numeric" class="form-control" id="revenueAmount"
                                            name="editRevenueAmount" placeholder="Amount Spent"
                                            value=" <?php echo $revenueRowReturned["amount"] ?> " />
                                        <span class="text-danger"><?php echo $editRevenueAmountError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="description">Description</label>
                                        <input type="text" class="form-control" id="description"
                                            name="editRevenueDescription" placeholder="Describe your revenue"
                                            value=" <?php echo $revenueRowReturned["revenue_description"] ?> " />
                                        <span class="text-danger"><?php echo $editRevenueDescriptionError; ?></span>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="revenues.php" class="btn btn-secondary" name="btn_close">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="updateRevenue"
                                            name="updateRevenue">Save
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