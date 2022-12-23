<?php
require("controllers/process-edit-expense.php");
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
        <title>Pesa Manager | Edit Expense</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <?php if (isset($_POST["updateExpense"])) {
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
                if (isset($_GET["edit_expense"]) && isset($_SESSION["user_id"]) && $conn) {
                    $loggedInUser = $_SESSION["user_id"];
                    $fetchedExpenseId = testData($_GET["edit_expense"]);
                    $fetchedExpenseId = filter_var($fetchedExpenseId, FILTER_VALIDATE_INT);
                    $sqlFetchEditExpense = "SELECT expenses.expense_id,expenses.item, expenses.amount, expenses.expense_description FROM expenses INNER JOIN registration ON expenses.user_id = registration.user_id WHERE expenses.user_id = '$loggedInUser' AND expenses.expense_id = '$fetchedExpenseId'";
                    $fetchedEditExpenseResult = mysqli_query($conn, $sqlFetchEditExpense);

                    if (mysqli_num_rows($fetchedEditExpenseResult) === 1) {
                        while ($expenseRowReturned = mysqli_fetch_assoc($fetchedEditExpenseResult)) {
                ?>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="modalLabel">Edit Expense Record</h5>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="edit-expense.php?edit_expense= <?php echo $expenseRowReturned["expense_id"]; ?>"
                                    method="POST">
                                    <div class=" form-group">
                                        <label class="form-label" for="item">Item</label>
                                        <input type="text" class="form-control" id="item" name="editExpenseItem"
                                            placeholder="Enter an item"
                                            value=" <?php echo $expenseRowReturned["item"] ?> " />
                                        <span class="text-danger"><?php echo $editExpenseItemError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="expenseAmount">Amount</label>
                                        <input inputmode="numeric" class="form-control" id="editEeditExpenseAmount"
                                            name="editExpenseAmount" placeholder="Amount Spent"
                                            value=" <?php echo $expenseRowReturned["amount"] ?> " />
                                        <span class="text-danger"><?php echo $editExpenseAmountError; ?></span>
                                    </div>
                                    <div class="form-group my-2">
                                        <label class="form-label" for="description">Description</label>
                                        <input type="text" class="form-control" id="description"
                                            name="editExpenseDescription" placeholder="Describe your expense"
                                            value=" <?php echo $expenseRowReturned["expense_description"] ?> " />
                                        <span class="text-danger"><?php echo $editExpenseDescriptionError; ?></span>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="expenditures.php" class="btn btn-secondary">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="updateExpense"
                                            name="updateExpense">Save
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