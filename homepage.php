<?php
require("includes/process.php");
if (empty($_SESSION["user_id"]) && empty($_SESSION["role"])) {
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
        <title>Pesa Manager | Homepage</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper bg-img-wrapper-home vh-100">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <div class="jumbotron py-5 text-center">
                        <div class="container d-flex justify-content-center flex-column align-items-center">
                            <h2 class="hero-title">Welcome
                                <?php
                            if (isset($_SESSION["username"]) && isset($_SESSION["role"])) {
                                if ($_SESSION["role"] == "user") {
                                    echo $_SESSION["username"];
                                } else {
                                    echo ucwords($_SESSION["role"]);
                                }
                            }
                            ?>
                            </h2>
                            <p class="hero-text">
                                Track all your revenue and expenditure on the fly with our stunning app to boost your
                                productivity and management.
                            </p>
                        </div>
                        <div class="selection">
                            <select class="form-select" name="userSelection" id="userTypeSelection">
                                <option value="-1" selected disabled>What to add</option>
                                <option value="expense">Expense</option>
                                <option value="revenue">Revenue</option>
                            </select>
                        </div>
                    </div>
                    <div class="container d-flex justify-content-center flex-column align-items-center mt-3">
                        <h3 class="title-balance text-center">BALANCE</h3>
                        <button class="btn btn-outline-light mt-1" data-bs-toggle="modal"
                            data-bs-target="#openViewBalanceModal">View Details</button>
                        <!-- View Balance Modal -->
                        <div class="modal fade" id="openViewBalanceModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel"> Account Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <?php
                                        if (isset($_SESSION["user_id"])) {
                                            $loggedInUser = testData($_SESSION["user_id"]);
                                            $sqlTotalRevenue = "SELECT (revenues.amount) FROM revenues INNER JOIN registration ON revenues.user_id = registration.user_id WHERE revenues.user_id = '$loggedInUser'";
                                            $totalRevenueResult = mysqli_query($conn, $sqlTotalRevenue);
                                            $totalRevenues = 0;
                                            if (mysqli_num_rows($totalRevenueResult) > 0) {
                                                while ($totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult)) {
                                                    $totalRevenues +=  $totalRevenueRow["amount"]
                                        ?>

                                            <?php } ?>
                                            <h2 class="details-type">Total Revenue: <span
                                                    class="revenue-alert"><?php echo $totalRevenues  ?></span>
                                            </h2>
                                            <?php } else { ?>
                                            <h2 class="details-type">Total Revenue: <span
                                                    class="revenue-alert"><?php echo $totalRevenues  ?></span>
                                            </h2>
                                            <?php } ?>
                                            <?php } ?>

                                            ?>

                                            <?php
                                        if (isset($_SESSION["user_id"])) {
                                            $loggedInUser = testData($_SESSION["user_id"]);
                                            $sqlTotalExpense = "SELECT (expenses.amount) FROM expenses INNER JOIN registration ON expenses.user_id = registration.user_id WHERE expenses.user_id = '$loggedInUser'";
                                            $totalExpenseResult = mysqli_query($conn, $sqlTotalExpense);
                                            $totalExpenses = 0;
                                            if (mysqli_num_rows($totalExpenseResult) > 0) {
                                                while ($totalExpenseRow = mysqli_fetch_assoc($totalExpenseResult)) {
                                                    $totalExpenses  += $totalExpenseRow["amount"];
                                        ?>
                                            <?php } ?>
                                            <h2 class="details-type">Total Expense: <span class="expense-alert">
                                                    <?php echo $totalExpenses; ?>
                                                </span>
                                            </h2>
                                            <?php  } else { ?>
                                            <h2 class="details-type">Total Expense: <span class="expense-alert">
                                                    <?php echo $totalExpenses; ?>
                                                </span>
                                            </h2>
                                            <?php } ?>
                                            <?php } ?>

                                            ?>

                                            <?php
                                        if (isset($_SESSION["user_id"])) {
                                            $loggedInUser = testData($_SESSION["user_id"]);
                                            $sqlTotalExpense = "SELECT (expenses.amount) FROM expenses INNER JOIN registration ON expenses.user_id = registration.user_id WHERE expenses.user_id = '$loggedInUser'";
                                            $sqlTotalRevenue = "SELECT (revenues.amount) FROM revenues INNER JOIN registration ON revenues.user_id = registration.user_id WHERE revenues.user_id = '$loggedInUser'";
                                            $totalRevenueResult = mysqli_query($conn, $sqlTotalRevenue);
                                            $totalExpenseResult = mysqli_query($conn, $sqlTotalExpense);
                                            $totalExpenses = 0;
                                            $totalRevenues = 0;
                                            $balance = 0;
                                            if (mysqli_num_rows($totalExpenseResult) > 0) {
                                                while ($totalExpenseRow = mysqli_fetch_assoc($totalExpenseResult)) {
                                                    $totalExpenses += $totalExpenseRow["amount"];
                                                }
                                            }

                                            if (mysqli_num_rows($totalRevenueResult) > 0) {
                                                while ($totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult)) {
                                                    $totalRevenues += $totalRevenueRow["amount"];
                                                }
                                            }
                                            $balance = $totalRevenues - $totalExpenses;

                                            if ($balance < 0) {
                                        ?>
                                            <h2 class="details-type">Balance: <span
                                                    class="bg-danger text-light p-1"><?php echo $balance; ?></span>
                                            </h2>
                                            <?php } elseif ($balance > 0) { ?>
                                            <h2 class="details-type">Balance: <span
                                                    class="bg-success text-light p-1"><?php echo $balance; ?></span>
                                            </h2>
                                            <?php } else { ?>
                                            <h2 class="details-type">Balance: <span
                                                    class="bg-secondary text-light p-1"><?php echo $balance; ?></span>
                                            </h2>
                                            <?php } ?>

                                            <?php } ?>

                                            ?>
                                        </div>
                                        <div class="container">
                                            <p class="balance-meaning">Balance is the difference between the total
                                                revenues
                                                and the total expenses.</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            OK
                                        </button>
                                    </div>
                                </div>
                            </div>
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