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
        <title>Pesa Manager | View Revenue</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php
                if (isset($_GET["view_revenue"]) && isset($_SESSION["user_id"]) && $conn) {
                    $loggedInUser = $_SESSION["user_id"];
                    $fetchedViewRevenueId = testData($_GET["view_revenue"]);
                    $fetchedViewRevenueId = filter_var($fetchedViewRevenueId, FILTER_VALIDATE_INT);
                    $sqlFetchEditRevenue = "SELECT revenues.revenue_id, revenues.item, revenues.amount, revenues.revenue_description, revenues.date_created FROM revenues INNER JOIN registration ON revenues.user_id = registration.user_id WHERE revenues.user_id = '$loggedInUser' AND revenues.revenue_id = '$fetchedViewRevenueId'";
                    $fetchedViewRevenueResult = mysqli_query($conn, $sqlFetchEditRevenue);

                    if (mysqli_num_rows($fetchedViewRevenueResult) === 1) {
                        while ($revenueRowReturned = mysqli_fetch_assoc($fetchedViewRevenueResult)) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">View Revenue Details</h5>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="view-revenue.php?view_revenue= <?php echo $revenueRowReturned["revenue_id"]; ?>"
                                    method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="item">Item</label>
                                        <input type="text" class="form-control"
                                            value=" <?php echo $revenueRowReturned["item"]; ?> " readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="revenueAmount">Amount</label>
                                        <input class="form-control" id="editrevenueAmount"
                                            value=" <?php echo $revenueRowReturned["amount"]; ?> " readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea class="form-control"
                                            readonly><?php echo $revenueRowReturned["revenue_description"]; ?> </textarea>
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="revenueAmount">Date & Time</label>
                                        <input class="form-control"
                                            value=" <?php echo date($revenueRowReturned["date_created"]); ?> "
                                            readonly />
                                    </div>
                                    <div class="modal-footer">
                                        <a href="revenues.php" class="btn d-block btn-secondary" id="updaterevenue"
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