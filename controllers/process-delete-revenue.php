<?php

if (!$conn) {
  echo "Connection Error: " . mysqli_connect_error();
} else {

  // delete revenue record 
  if (isset($_GET["delete_revenue"])) {
    $deletedRevenue = testData($_GET["delete_revenue"]);
    $deletedRevenueQuery = "DELETE FROM revenues WHERE revenue_id='$deletedRevenue'";
    $deleteRecord = mysqli_query($conn, $deletedRevenueQuery);
    if (!$deleteRecord) {
      $_SESSION["msg-type"] = "warning";
      $_SESSION["message"] = "Failed to delete record.";
    } else {
      $_SESSION["msg-type"] = "danger";
      $_SESSION["message"] = "Expense deleted successfully.";
      header("refresh:3, url=revenues.php");
    }
  }
}