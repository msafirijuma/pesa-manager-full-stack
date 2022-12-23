<?php

require("includes/process.php");
// emptying edit revenue
$editRevenueItem = $editRevenueAmount = $editRevenueDescription = "";
$editRevenueItemError = $editRevenueAmountError = $editRevenueDescriptionError = "";

// edit revenue record
if (isset($_POST["updateRevenue"])) {
    if ($conn) {

        if (isset($_GET["edit_revenue"])) {

            $loggedInUser = $_SESSION["user_id"];
            $fetchedRevenueId = $_GET["edit_revenue"];
            $editRevenueItem = testData($_POST["editRevenueItem"]);
            $editRevenueAmount = testData($_POST["editRevenueAmount"]);
            $editRevenueDescription = testData($_POST["editRevenueDescription"]);

            // Validate input (item)
            if (empty($editRevenueItem)) {
                $editRevenueItemError = "Item is required";
            } else {
                if (!preg_match("/^[a-zA-Z]*$/", $editRevenueItem)) {
                    $$editRevenueItemError = "Only letters are required";
                }
            }

            // Validate input (amount)
            if (empty($editRevenueAmount)) {
                $editRevenueAmountError = "Amount is required";
            } elseif (!(filter_var($editRevenueAmount, FILTER_VALIDATE_INT))) {
                $editRevenueAmountError = "Only numbers are required";
            }

            // Validate input (description)
            if (empty($editRevenueDescription)) {
                $editRevenueDescriptionError = "Description is required";
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($editRevenueItemError == "" && $editRevenueAmountError == "" && $editRevenueDescriptionError == "") {
                    $sqlEditedRevenue = "UPDATE revenues SET revenues.item = '$editRevenueItem',  revenues.amount = $editRevenueAmount, revenues.revenue_description = '$editRevenueDescription' WHERE revenues.user_id = '$loggedInUser' AND revenues.revenue_id = '$fetchedRevenueId' ";
                    $editedRevenueResult = mysqli_query($conn, $sqlEditedRevenue);
                    if (!$editedRevenueResult) {
                        $_SESSION["msg-type"] = "danger";
                        $_SESSION["message"] = "Failed to query database.";
                    } else {
                        $_SESSION["msg-type"] = "warning";
                        $_SESSION["message"] = "Revenue updated successfully.";
                        header("refresh:2 , url= revenues.php");
                    }
                } else {
                    $_SESSION["msg-type"] = "danger";
                    $_SESSION["message"] = "Failed to update record.";
                }
            }
        }
    }
}