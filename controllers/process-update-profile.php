<?php
require("includes/process.php");
$updateUsername = $updatePhoneNumber = $updateUserLocation = "";
$updateUsernameError = $updateUserLocationError = $updatePhoneNumberError = "";

// update user profile
if (isset($_POST["updateUserProfile"])) {
    if ($conn) {

        $activeUser = $_SESSION["user_id"];
        $updateUsername = testData($_POST["updateUsername"]);
        $updateUserLocation = testData($_POST["updateUserLocation"]);
        $updatePhoneNumber = testData($_POST["updatePhoneNumber"]);


        // Validate username
        if (empty($updateUsername)) {
            $updateUsernameError = "Item is required";
        } else {
            if (!preg_match("/^[a-zA-Z- ']*$/", $updateUsername)) {
                $updateUsernameError = "Only letters are required";
            }
        }

        // Validate location
        if (empty($updateUserLocation)) {
            $updateUserLocationError = "Item is required";
        } else {
            if (!preg_match("/^[\'a-zA-Z]*$/", $updateUserLocation)) {
                $updateUserLocationError = "Only letters are required";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($updatePhoneNumberError == "" && $updateUserLocationError == "" && $updateUsernameError == "") {

                $sqlUserProfile = "UPDATE registration SET  username = ?,  user_location = ?, phone_number = ? WHERE user_id = ? ";

                // prepare, bind_param and execute query
                $updateUserProfile = $conn->prepare($sqlUserProfile);
                $updateUserProfile->bind_param("ssii", $updateUsername, $updateUserLocation, $updatePhoneNumber, $activeUser);
                $updateUserProfile->execute();

                if (!$updateUserProfile) {
                    $_SESSION["msg-type"] = "danger";
                    $_SESSION["message"] = "Failed to update record.";
                } else {
                    $_SESSION["msg-type"] = "success";
                    $_SESSION["message"] = "Profile updated successfully.";
                    $_SESSION['username'] = $updateUsername;
                    header("refresh:2 , url= homepage.php");
                }
            }
        }
    }
}