<?php
require("includes/process.php");
if (!$conn) {
    echo "Connection Error: " . mysqli_connect_error();
} else {

    // delete user 
    if (isset($_GET["delete_user"])) {
        $deleteUser = testData($_GET["delete_user"]);
        // $sqlDropFKRevenue = "ALTER TABLE revenues DROP FOREIGN KEY fr_user_revenue";
        // $sqlDropFKExpense = "ALTER TABLE expenses DROP FOREIGN KEY fr_user_expense";
        // $dropFKRevenue = mysqli_query($conn, $sqlDropFKRevenue);
        // $dropFKExpense = mysqli_query($conn, $sqlDropFKExpense);
        $sqlDeleteUser = "DELETE FROM registration WHERE user_id='$deleteUser'";
        $deleteRecord = mysqli_query($conn, $sqlDeleteUser);
        if (!$deleteRecord) {
            $_SESSION["msg-type"] = "warning";
            $_SESSION["message"] = "Failed to delete record.";
        } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "User deleted successfully.";
            // $sqlAddFKRevenue = "ALTER TABLE revenues ADD CONSTRAINT fr_user_revenue FOREIGN KEY (user_id) REFERENCES registration(user_id) ON DELETE RESTRICT ON UPDATE RESTRICT";
            // $sqlAddFKExpense = "ALTER TABLE expenses ADD CONSTRAINT fr_user_expense FOREIGN KEY (user_id) REFERENCES registration(user_id) ON DELETE RESTRICT ON UPDATE RESTRICT";
            // $addFKRevenue = mysqli_query($conn, $sqlAddFKRevenue);
            // $addFKExpense = mysqli_query($conn, $sqlAddFKExpense);
            // header("refresh:3, url=users.php");
        }
    }
}