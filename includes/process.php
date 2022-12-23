<?php
session_start();
require("connect.php");

// Emptying inputs fields;
$email = $password = $username = $location = $phoneNumber =  $confirmPassword = $emailLogin = $passwordLogin = "";
$emailError = $passwordError = $usernameError = $confirmPasswordError = "";
$emailLoginError = $passwordLoginError = "";
$locationError = $phoneNumberError = "";
$_SESSION["message"] = "";
$_SESSION["msg-type"] = "";


function testData($data)
{
   $data = trim($data);
   $data = htmlentities($data);
   $data = stripslashes($data);
   return $data;
}

// register a user
if (isset($_POST["register"])) {
   $email = testData($_POST["email"]);
   $password = testData($_POST["password"]);
   $username = testData($_POST["username"]);
   $confirmPassword = testData($_POST["confirmPassword"]);
   $location = testData($_POST["location"]);
   $phoneNumber = testData($_POST["phoneNumber"]);
   $defaultRole = "user";


   if (!$conn) {
      echo "Connection Error: " . mysqli_connect_error();
   } else {

      //    Username validation
      if (empty($username)) {
         $usernameError = "Username is required";
      } else {
         //    $username = testData($_POST["username"]);
         if (!preg_match("/^[a-zA-Z- ']*$/", $username)) {
            $usernameError = "Username can contain only letters and whitespace";
         }
      }

      // location validation
      if (!preg_match("/^[a-zA-Z- ']*$/", $location)) {
         $locationError = "location can contain only letters and whitespace";
      }

      //    Email validation


      if (empty($email)) {
         $emailError = "Email is required";
      } else {
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email address";
         } else {
            $sqlCheckingEmailAddress = "SELECT email FROM registration WHERE email = ? LIMIT 1";

            // prepare, bind_param and execute query
            $checkingEmailAddress = $conn->prepare($sqlCheckingEmailAddress);
            $checkingEmailAddress->bind_param("s", $email);
            $checkingEmailAddress->execute();
            $checkingEmailAddressResult = $checkingEmailAddress->get_result();
            $checkingEmailAddressRow = $checkingEmailAddressResult->fetch_assoc();

            if ($checkingEmailAddressRow) {
               $emailError = "Email is already taken by another user";
            }
         }
      }

      // Password Validation   
      if (empty($password)) {
         $passwordError = "Password is required";
      } else {
         // $password = $_POST["password"];
         $passwordLength = strlen($password);
         $numberCheck = preg_match('@[0-9]@', $password);
         $lowercaseCheck = preg_match('@[a-z]@', $password);
         $specialCharactersCheck = preg_match('@[^\w]@', $password);

         if ($passwordLength < 6) {
            $passwordError = "Password must be atleast 6 characters in length";
         } elseif (!$numberCheck) {
            $passwordError = "Password must include atleast one number";
         } elseif (!$lowercaseCheck) {
            $passwordError = "Password must include atleast one lowercase characters";
         } elseif (!$specialCharactersCheck) {
            $passwordError = "Password must contain special characters";
         }
      }


      // Password rematch   
      if ($password != $confirmPassword) {
         $confirmPasswordError = "Passwords do not match";
      }

      if ($_SERVER['REQUEST_METHOD'] == "POST") {
         if (
            $usernameError == "" && $locationError == ""
            && $emailError == "" && $passwordError == "" && $confirmPasswordError == ""
         ) {
            $password = md5($password);
            $sql = "INSERT INTO registration (username, email, user_password, user_location, phone_number, role_type, date_registered) VALUES (?, ?, ?, ?, ?, ?, current_timestamp())";
            $statement = $conn->prepare($sql);
            $statement->bind_param("ssssis", $username, $email, $password, $location, $phoneNumber, $defaultRole);
            $statement->execute();

            $_SESSION["msg-type"] = "success";
            $_SESSION["message"] = "Congrats! Login now.";
            header("refresh: 3; url= includes/login.php");
         } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "Something went wrong! Try to register again.";
         }
      }
   }
}


// user login in the system
if (isset($_POST["login"])) {

   if (!$conn) {
      echo "Connection Error " . mysqli_connect_error();
   } else {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $emailLogin = testData($_POST["emailLogin"]);
         $passwordLogin = testData($_POST["passwordLogin"]);

         //    Email validation
         if (empty($emailLogin)) {
            $emailLoginError = "Email is required";
         } else {
            //    $email = $_POST["email"];
            if (!filter_var($emailLogin, FILTER_VALIDATE_EMAIL)) {
               $emailLoginError = "Invalid email address";
            }
         }

         // Password Validation   
         if (empty($passwordLogin)) {
            $passwordLoginError = "Password is required";
         }

         $passwordLogin = md5($passwordLogin);
         $query = "SELECT * FROM registration WHERE email = ? AND user_password = ? ";
         $stmt = $conn->prepare($query);
         $stmt->bind_param("ss", $emailLogin, $passwordLogin);
         $stmt->execute();
         $userResult = $stmt->get_result();
         $singleUserRow = $userResult->fetch_assoc();
         if ($singleUserRow) {
            $_SESSION["user_id"] = $singleUserRow["user_id"];
            $_SESSION["username"] = $singleUserRow["username"];
            $_SESSION["role"] = $singleUserRow["role_type"];
            $_SESSION["msg-type"] = "success";
            $_SESSION["message"] = "User login successfully.";
            if (isset($_SESSION["user_id"])) {
               header("refresh: 3; url= ../homepage.php");
            }
         } else {
            $_SESSION["msg-type"] = "danger";
            $_SESSION["message"] = "Incorrect email and password combination.";
         }
      }
   }
}

// Emptying values on closing modal
if ((isset($_SESSION["user_id"])) && (isset($_POST["btn_close"]))) {
   $itemError = "";
   $expenseAmountError = "";
   $descriptionError = "";
}

// mysqli_close($conn);

//  logout session
if (isset($_GET['logout'])) {
   session_destroy();
   unset($_SESSION["user_id"]);
   unset($_SESSION["username"]);
   header("location: includes/login.php ");
}