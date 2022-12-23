<?php
require("controllers/process-add-expense.php");
require("controllers/process-sort-expenses.php");
require("controllers/process-delete-expense.php");
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
        <title>Pesa Manager | Expenditures</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper">
            <div class="row">
                <?php
            require("includes/header.php")
            ?>
                <main class="col-lg-8 main py-1" id="main">
                    <div class="py-4 text-center">
                        <div class="container d-flex justify-content-center flex-column">
                            <?php
                        if (isset($_POST["addExpense"])) :
                        ?>
                            <div
                                class="d-flex justify-content-between w-100 alert alert-<?php echo $_SESSION['msg-type']; ?> ">
                                <span>
                                    <?php
                                    echo $_SESSION["message"];
                                    unset($_SESSION["message"])
                                    ?>
                                </span>
                                <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>
                            <h3 class="type-title display-6 mb-2">Expenses</h3>
                            <!-- Sort By -->
                            <form action="view-sorted-expenses.php" method="POST">
                                <div class="input-group">
                                    <select name="sortExpense" id="sortExpense" class="form-select">
                                        <option value="-1" disabled selected>Sort Expenses By</option>
                                        <option value="all">All</option>
                                        <option value="today">Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="week">Weekly</option>
                                        <option value="month1">1 Month</option>
                                        <option value="month3">3 Month</option>
                                        <option value="month6">6 Month</option>
                                        <option value="year">Annually</option>
                                    </select>
                                    <input type="submit" class="btn btn-primary" value="sort" name="sortExpenseBtn">
                                </div>
                            </form>

                            <!-- Display Expenses in the table here -->
                            <div class="table-responsive">
                                <table
                                    class="table table-width table-hover table-bordered table-striped bg-light caption-top my-2 mt-3">
                                    <caption class="top text-light text-center lead h2">List Of Expenses</caption>
                                    <thead class="bg-dark text-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Expense</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if (!$conn) {
                                        echo "Connection Error: " . mysqli_connect_error();
                                    } else {
                                        $expenseIndex = 1;
                                        $loggedInUser = $_SESSION["user_id"];
                                        $sqlExpenses = "SELECT expenses.expense_id,expenses.item, expenses.amount, expenses.date_created FROM expenses INNER JOIN registration ON expenses.user_id = registration.user_id WHERE expenses.user_id = '$loggedInUser'";
                                        $expenseResult = mysqli_query($conn, $sqlExpenses);
                                        if (mysqli_num_rows($expenseResult) > 0) {
                                            while ($expenseRow = mysqli_fetch_assoc($expenseResult)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $expenseIndex++; ?></th>
                                            <td><?php echo $expenseRow["item"]; ?></td>
                                            <td><?php echo $expenseRow["amount"]; ?></td>
                                            <td><?php echo $expenseRow["date_created"]; ?></td>
                                            <td colspan="2" class="d-flex">
                                                <a href="view-expense.php?view_expense=<?php echo $expenseRow["expense_id"]; ?>"
                                                    title="View Expense"
                                                    class="d-flex mx-1 btn btn-info btn-sm text-light">
                                                    <i class="fas fa-eye me-1"></i><span
                                                        class="action-btn">View</span></a>
                                                <a href="edit-expense.php?edit_expense=<?php echo $expenseRow["expense_id"]; ?>"
                                                    onclick="return confirm('You are about to edit this record. Are you sure?')"
                                                    title="Edit Expense"
                                                    class="d-flex mx-1 btn btn-warning btn-sm text-light">
                                                    <i class="fas fa-edit me-1"></i><span
                                                        class="action-btn">Edit</span></a>
                                                <a href="expenditures.php?delete_expense=<?php echo $expenseRow["expense_id"]; ?>"
                                                    onclick=" return confirm('Are you sure you want to delete this record?')"
                                                    title="Delete Expense"
                                                    class="d-flex mx-1 btn btn-danger btn-sm text-light">
                                                    <i class="fas fa-trash-alt me-1"></i>
                                                    <span class="action-btn">Delete</span></a>
                                            </td>
                                            <?php  ?>
                                        </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <div class="my-2">No records! All expenses will be shown here</div>
                                        <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <!-- Add New Expense Btn -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#openExpenseModal"
                            class="btnAddNewExpense btn text-light" title="Add New Expense">
                            <span class="btnCategory"> &plus; </span>
                        </button>
                    </div>
            </div>

            <!-- Expense Modal -->
            <div class="modal fade" id="openExpenseModal">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Add New Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="expenditures.php" method="POST">
                                <div class=" form-group">
                                    <label class="form-label" for="item">Item</label>
                                    <input type="text" class="form-control" id="item" name="expenseItem"
                                        placeholder="Enter an item" />
                                    <span class="text-danger"><?php echo $expenseItemError; ?></span>
                                </div>
                                <div class="form-group my-2">
                                    <label class="form-label" for="expenseAmount">Amount</label>
                                    <input inputmode="numeric" class="form-control" id="expenseAmount"
                                        name="expenseAmount" placeholder="Amount Spent" />
                                    <span class="text-danger"><?php echo $expenseAmountError; ?></span>
                                </div>
                                <div class="form-group my-2">
                                    <label class="form-label" for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="expenseDescription"
                                        placeholder="Describe your expense" />
                                    <span class="text-danger"><?php echo $expenseDescriptionError; ?></span>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-secondary" name="btn_close"
                                        data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="addExpense" name="addExpense">Add
                                        Expense</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
        <!-- Footer -->
        <?php
    require("includes/footer.php")
    ?>
        </div>

        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/scripts/hamburger.js"></script>
        <!-- <script src="assets/scripts/theme.js"></script> -->
        <script src="assets/scripts/app.js"></script>
    </body>

</html>