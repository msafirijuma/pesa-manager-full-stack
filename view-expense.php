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
        <title>Pesa Manager | View Expense</title>
    </head>

    <body>
        <div class="container-full bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php
                if (isset($_GET["view_expense"]) && isset($_SESSION["user_id"]) && $conn) {
                    $loggedInUser = $_SESSION["user_id"];
                    $fetchedViewExpenseId = testData($_GET["view_expense"]);
                    $fetchedViewExpenseId = filter_var($fetchedViewExpenseId, FILTER_VALIDATE_INT);
                    $sqlFetchEditExpense = "SELECT expenses.expense_id,expenses.item, expenses.amount, expenses.expense_description, expenses.date_created FROM expenses INNER JOIN registration ON expenses.user_id = registration.user_id WHERE expenses.user_id = '$loggedInUser' AND expenses.expense_id = '$fetchedViewExpenseId'";
                    $fetchedViewExpenseResult = mysqli_query($conn, $sqlFetchEditExpense);

                    if (mysqli_num_rows($fetchedViewExpenseResult) === 1) {
                        while ($expenseRowReturned = mysqli_fetch_assoc($fetchedViewExpenseResult)) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">View Expense Details</h5>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="view-expense.php?view_expense= <?php echo $expenseRowReturned["expense_id"]; ?>"
                                    method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="item">Item</label>
                                        <input class="form-control" value=" <?php echo $expenseRowReturned["item"]; ?> "
                                            readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="expenseAmount">Amount</label>
                                        <input class="form-control"
                                            value=" <?php echo $expenseRowReturned["amount"]; ?> " readonly />
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="description">Description</label>
                                        <textarea class="form-control"
                                            readonly><?php echo $expenseRowReturned["expense_description"]; ?> </textarea>
                                    </div>
                                    <div class="form-group my-1">
                                        <label class="form-label" for="description">Date & Time</label>
                                        <input class="form-control"
                                            value=" <?php echo date($expenseRowReturned["date_created"]); ?> "
                                            readonly />
                                    </div>
                                    <div class="modal-footer">
                                        <a href="expenditures.php" class="btn d-block btn-secondary">OK</a>
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