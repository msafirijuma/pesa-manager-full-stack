<div class="container mt-1">
    <?php require("includes/sort-expense-header-details.php") ?>
    <table class="table table-width table-hover table-striped bg-light caption-top my-2 mt-3">
        <caption class="top text-dark display-6 text-center">Expenses Report Form (Weekly)</caption>
        <thead class="bg-dark text-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Expense</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col" class="not-print">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $activeUser = $_SESSION["user_id"];
            $sqlWeek = "SELECT * FROM expenses INNER JOIN registration ON expenses.user_id = registration.user_id WHERE expenses.user_id = '$activeUser' AND expenses.date_created BETWEEN DATE_SUB( CURDATE(), INTERVAL 7 DAY) AND CURDATE()";
            $weekResult = mysqli_query($conn, $sqlWeek);


            if (mysqli_num_rows($weekResult) > 0) {
                $expenseIndex = 1;
                $sumExpenses = 0;
                while ($rowWeek = mysqli_fetch_assoc($weekResult)) {
                    $sumExpenses += $rowWeek["amount"];
            ?>

            <tr>
                <th scope="row"><?php echo $expenseIndex++; ?></th>
                <td><?php echo $rowWeek["item"]; ?></td>
                <td><?php echo $rowWeek["amount"]; ?></td>
                <td><?php echo $rowWeek["date_created"]; ?></td>
                <td><?php echo $rowWeek["expense_description"]; ?></td>
                <td colspan="2" class="not-print d-flex">
                    <a href="view-expense.php?view_expense=<?php echo $rowWeek["expense_id"]; ?>" title="View Expense"
                        class="d-flex mx-1 btn btn-info text-light">
                        <i class="fas fa-eye me-1"></i><span class="action-btn">View</span></a>
                    <a href="edit-expense.php?edit_expense=<?php echo $rowWeek["expense_id"]; ?>"
                        onclick="return confirm('You are about to edit this record. Are you sure?')"
                        title="Edit Expense" class="d-flex mx-1 btn btn-success text-light">
                        <i class="fas fa-edit me-1"></i><span class="action-btn">Edit</span></a>
                    <a href="expenditures.php?delete_expense=<?php echo $rowWeek["expense_id"]; ?>"
                        onclick=" return confirm('Are you sure you want to delete this record?')" title="Delete Expense"
                        class="d-flex mx-1 btn btn-danger text-light">
                        <i class="fas fa-trash-alt me-1"></i>
                        <span class="action-btn">Delete</span></a>
                </td>
            </tr>
            <?php } ?>
            <tr class="bg-secondary text-light display-6">
                <td colspan="6" class="total-expense-label">Total Expenses: <?php echo $sumExpenses; ?></td>
            </tr>
            <?php } else { ?>
            <div class="alert alert-info">
                <span>No record for today.</span>
                <button class="btn-close ms-2" data-bs-dismiss="alert" title="Close"></button>
            </div>
            <?php } ?>
        </tbody>
    </table>
</div>