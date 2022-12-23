<?php

require("includes/process.php");
// emptying edit Expense
$editExpenseItem = $editExpenseAmount = $editExpenseDescription = "";
$editExpenseItemError = $editExpenseAmountError = $editExpenseDescriptionError = "";

// edit expense record
if (isset($_POST["updateExpense"])) {
    if ($conn) {

        if (isset($_GET["edit_expense"])) {

            $loggedInUser = $_SESSION["user_id"];
            $fetchedExpenseId = $_GET["edit_expense"];
            $editExpenseItem = testData($_POST["editExpenseItem"]);
            $editExpenseAmount = testData($_POST["editExpenseAmount"]);
            $editExpenseDescription = testData($_POST["editExpenseDescription"]);

            // Validate input (item)
            if (empty($editExpenseItem)) {
                $editExpenseItemError = "Item is required";
            } else {
                if (!preg_match("/^[a-zA-Z]*$/", $editExpenseItem)) {
                    $$editExpenseItemError = "Only letters are required";
                }
            }

            // Validate input (amount)
            if (empty($editExpenseAmount)) {
                $editExpenseAmountError = "Amount is required";
            } elseif (!(filter_var($editExpenseAmount, FILTER_VALIDATE_INT))) {
                $editExpenseAmountError = "Only numbers are required";
            }

            // Validate input (description)
            if (empty($editExpenseDescription)) {
                $editExpenseDescriptionError = "Description is required";
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($editExpenseItemError == "" && $editExpenseAmountError == "" && $editExpenseDescriptionError == "") {
                    $sqlEditedExpense = "UPDATE expenses SET expenses.item = '$editExpenseItem',  expenses.amount = $editExpenseAmount, expenses.expense_description = '$editExpenseDescription' WHERE expenses.user_id = '$loggedInUser' AND expenses.expense_id = '$fetchedExpenseId' ";
                    $editedExpenseResult = mysqli_query($conn, $sqlEditedExpense);
                    if (!$editedExpenseResult) {
                        $_SESSION["msg-type"] = "danger";
                        $_SESSION["message"] = "Failed to query database.";
                    } else {
                        $_SESSION["msg-type"] = "warning";
                        $_SESSION["message"] = "Expense updated successfully.";
                        header("refresh:2 , url= expenditures.php");
                    }
                } else {
                    $_SESSION["msg-type"] = "danger";
                    $_SESSION["message"] = "Failed to update record.";
                }
            }
        }
    }
}