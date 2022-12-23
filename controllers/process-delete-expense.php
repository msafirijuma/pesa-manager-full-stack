<?php

if (!$conn) {
  echo "Connection Error: " . mysqli_connect_error();
} else {

  // delete expense record 
  if (isset($_GET["delete_expense"])) {
    $deletedExpense = testData($_GET["delete_expense"]);
    $deletedExpenseQuery = "DELETE FROM expenses WHERE expense_id='$deletedExpense'";
    $deleteRecord = mysqli_query($conn, $deletedExpenseQuery);
    if (!$deleteRecord) {
      $_SESSION["msg-type"] = "warning";
      $_SESSION["message"] = "Failed to delete record.";
      echo '<div class="alert alert-danger">
          <span>Failed to delete record.</span>
          <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
          </div>';
    } else {
      $_SESSION["msg-type"] = "danger";
      $_SESSION["message"] = "Expense deleted successfully.";
      header("refresh:3, url=expenditures.php");
    }
  }
}