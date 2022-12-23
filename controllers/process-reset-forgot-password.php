<?php
$resetUpdatePassword = "";
$resetUpdatePasswordError = "";
$resetUpdateConfirmPassword = "";
$resetUpdateConfirmPasswordError = "";
// $token = $_SESSION["token"];

if (isset($_POST["updateResetPassword"]) && $conn) {

    $resetUpdatePassword = testData($_POST["resetUpdatePassword"]);
    $resetUpdateConfirmPassword = testData($_POST["resetUpdateConfirmPassword"]);

    // Password Validation   
    if (empty($resetUpdatePassword)) {
        $resetUpdatePasswordError = "Password is required";
    } else {

        $resetUpdatePasswordLength = strlen($resetUpdatePassword);
        $numberCheck = preg_match('@[0-9]@', $resetUpdatePassword);
        $lowercaseCheck = preg_match('@[a-z]@', $resetUpdatePassword);
        $specialCharactersCheck = preg_match('@[^\w]@', $resetUpdatePassword);

        if ($resetUpdatePasswordLength < 6) {
            $resetUpdatePasswordError = "Password must be atleast 6 characters in length";
        } elseif (!$numberCheck) {
            $resetUpdatePasswordError = "Password must include atleast one number";
        } elseif (!$lowercaseCheck) {
            $resetUpdatePasswordError = "Password must include atleast one lowercase characters";
        } elseif (!$specialCharactersCheck) {
            $resetUpdatePasswordError = "Password must contain special characters";
        }
    }

    // Password rematch   
    if ($resetUpdatePassword != $resetUpdateConfirmPassword) {
        $resetUpdateConfirmPasswordError = "Passwords do not match";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($resetUpdatePasswordError == "" && $resetUpdateConfirmPasswordError == "") {
            $sqlEmailFeedback = "SELECT email_id FROM reset_passwords where token = ? ";
            // prepare, bind_param and execute query
            $emailFeedback = $conn->prepare($sqlEmailFeedback);
            $emailFeedback->bind_param("s", $token);
            $emailFeedback->execute();
            $emailFeedbackResult = $emailFeedback->get_result();
            $rowEmail = $emailFeedbackResult->fetch_assoc();
            if ($rowEmail) {
                $emailAssignedToken = $rowEmail["user_email"];
                $sqlUpdateUserPassword = "UPDATE registration SET user_password = ? WHERE email = ? ";
                $updateUserPassword = $conn->prepare($sqlUpdateUserPassword);
                $updateUserPassword->bind_param("ss", $resetUpdatePassword, $emailAssignedToken);

                $_SESSION["message"] = "Password was reset successfully. Login with your new password.";
                $_SESSION["msg-type"] = "success";
            } else {
                $_SESSION["msg-type"] = "danger";
                $_SESSION["message"] = "Failed to update user password.";
            }
        } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "Something went wrong. Try again.";
        }
    }
}