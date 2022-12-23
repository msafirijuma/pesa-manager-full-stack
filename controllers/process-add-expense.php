<?php
require("includes/process.php");


// Emptying Expense
$expenseItem = $expenseAmount = $expenseDescription = "";
$expenseItemError = $expenseAmountError = $expenseDescriptionError = "";

// add expense to db
if ((isset($_SESSION["user_id"])) && (isset($_POST["addExpense"]))) {
    $expenseItem = testData($_POST["expenseItem"]);
    $expenseAmount = testData($_POST["expenseAmount"]);
    $expenseDescription = testData($_POST["expenseDescription"]);

    // Validate input (item)
    if (empty($expenseItem)) {
        $expenseItemError = "Item is required";
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $expenseItem)) {
            $itemError = "Only letters are required";
        }
    }

    // Validate input (amount)
    if (empty($expenseAmount)) {
        $expenseAmountError = "Amount is required";
    } elseif (!(filter_var($expenseAmount, FILTER_VALIDATE_INT))) {
        $expenseAmountError = "Only numbers are required";
    }

    // Validate input (description)
    if (empty($expenseDescription)) {
        $expenseDescriptionError = "Description is required";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($expenseItemError == "" && $expenseAmountError == "" && $expenseDescriptionError == "") {
            $user_id = $_SESSION["user_id"];

            $sqlExpense = "INSERT INTO expenses (item, amount, date_created, user_id, expense_description) VALUES ('$expenseItem', '$expenseAmount', current_timestamp(), '$user_id', '$expenseDescription')";
            $single_expense = mysqli_query($conn, $sqlExpense);

            if (!($single_expense)) {
                $_SESSION["msg-type"] = "danger";
                $_SESSION["message"] = "Something went wrong. Failed to add data.";
            } else {
                $_SESSION["msg-type"] = "success";
                $_SESSION["message"] = "New data added successfully.";
            }
            header("refresh:3, url=expenditures.php");
        } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "Something went wrong. Failed to add data.";
        }
    }
}