<?php
require("includes/process.php");

// emptying revenue
$revenueItem = $revenueAmount = $revenueDescription = "";
$revenueItemError = $revenueAmountError = $revenueDescriptionError = "";

// add revenue to db
if ((isset($_SESSION["user_id"])) && (isset($_POST["addRevenue"]))) {
    $revenueItem = testData($_POST["revenueItem"]);
    $revenueAmount = testData($_POST["revenueAmount"]);
    $revenueDescription = testData($_POST["revenueDescription"]);

    // Validate input (item)
    if (empty($revenueItem)) {
        $revenueItemError = "Item is required";
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $revenueItem)) {
            $itemError = "Only letters are required";
        }
    }

    // Validate input (amount)
    if (empty($revenueAmount)) {
        $revenueAmountError = "Amount is required";
    } elseif (!(filter_var($revenueAmount, FILTER_VALIDATE_INT))) {
        $revenueAmountError = "Only numbers are required";
    }

    // Validate input (description)
    if (empty($revenueDescription)) {
        $revenueDescriptionError = "Description is required";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($revenueItemError == "" && $revenueAmountError == "" && $revenueDescriptionError == "") {
            $user_id = $_SESSION["user_id"];

            $sqlRevenue = "INSERT INTO revenues (item, amount, date_created, user_id, revenue_description) VALUES ('$revenueItem',
'$revenueAmount', current_timestamp(), '$user_id', '$revenueDescription')";
            $single_revenue = mysqli_query($conn, $sqlRevenue);

            if (!($single_revenue)) {
                $_SESSION["msg-type"] = "danger";
                $_SESSION["message"] = "Something went wrong. Failed to add data.";
            } else {
                $_SESSION["msg-type"] = "success";
                $_SESSION["message"] = "New data added successfully.";
            }
            header("refresh:3, url=revenues.php");
        } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "Something went wrong. Failed to add data.";
        }
    }
}