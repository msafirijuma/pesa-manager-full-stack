<?php
require("includes/process.php");

// emptying user
$roleType = $roleTypeError = "";

// edit user profile
if (isset($_POST["updateUser"])) {
    if ($conn) {

        if (isset($_GET["edit_user"])) {

            $loggedInUser = $_SESSION["user_id"];
            $fetchedUserId = $_GET["edit_user"];
            $roleType = testData($_POST["roleType"]);

            // Validate role
            if ($roleType == "default") {
                $roleTypeError = "Role is not selected";
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($roleTypeError == "") {
                    $sqlEditUserRole = "UPDATE registration SET role_type = ? WHERE user_id = ? LIMIT 1";
                    // prepare, bind_param and execute query
                    $editUserRole = $conn->prepare($sqlEditUserRole);
                    $editUserRole->bind_param("si", $roleType, $fetchedUserId);
                    $editUserRole->execute();

                    if ($editUserRole) {
                        $_SESSION["msg-type"] = "warning";
                        $_SESSION["message"] = "New role assigned successfuly.";
                        header("refresh:2 , url= users.php");
                    } else {
                        $_SESSION["msg-type"] = "danger";
                        $_SESSION["message"] = "Failed to assign new role to this user.";
                    }
                } else {
                    $_SESSION["msg-type"] = "danger";
                    $_SESSION["message"] = "Something went wrong.";
                }
            }
        }
    }
}