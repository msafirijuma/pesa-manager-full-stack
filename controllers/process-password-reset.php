<?php
require("includes/process.php");
$emailRequestReset = "";
$emailRequestResetError = "";

if (isset($_POST["resetPassword"]) && $conn) {
    $emailRequestReset = testData($_POST["emailRequestReset"]);

    //    Email validation
    if (empty($emailRequestReset)) {
        $emailRequestResetError = "Email is required";
    } else {
        if (!filter_var($emailRequestReset, FILTER_VALIDATE_EMAIL)) {
            $emailRequestResetError = "Invalid email address";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($emailRequestResetError == "") {

            $sqlCheckUserEmail = "SELECT * FROM registration WHERE email = ? LIMIT 1";
            //  prepare, bind param and execute query
            $checkUserEmailResult = $conn->prepare($sqlCheckUserEmail);
            $checkUserEmailResult->bind_param("s", $emailRequestReset);
            $checkUserEmailResult->execute();
            $result = $checkUserEmailResult->get_result();
            $rowEmail = $result->fetch_assoc();
            if ($rowEmail) {
                $_SESSION["msg-type"] = "success";
                $_SESSION["message"] = "Success! We've sent an email to your email account, login to your email account and click on the link to reset your password.";

                // Generate random token
                $token = random_bytes(50);
                $token = bin2hex($token);

                // Insert user email, generated token to the reset password table
                $sqlEmailTokenReset = "INSERT INTO reset_passwords (user_email, token) VALUES (?, ?)";

                // prepare, bind_param and execute query
                $emailTokenResult = $conn->prepare($sqlEmailTokenReset);
                $emailTokenResult->bind_param("ss", $emailRequestReset, $token);
                $emailTokenResult->execute();

                // Send an email to the registered user email address
                $to = $emailRequestReset;
                $subject = "Password Reset Request";
                $message = "Sorry for inconvinience,click <a href=\"create-new-password.php?token = " . $token . "\">here</a> to reset your password thus by clicking link you will be redirected to the website to continue with the next step. ";
                $message = wordwrap($message, 70);

                $header = "From: pesamanager.net ";

                mail($to, $subject, $message, $header);
            } else {
                $_SESSION["msg-type"] = "danger";
                $_SESSION["message"] = "This email address is not registered on our system.";
            }
        } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "Write a valid email address.";
        }
    }
}