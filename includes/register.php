<!-- Registration Form -->
<div class="tab-pane tab-pane-mobile mx-auto" id="signup">
    <?php if (isset($_POST["register"])) {
    ?>
    <div class="d-flex justify-content-between  alert alert-<?php echo $_SESSION['msg-type']; ?> ">
        <span>
            <?php
                echo $_SESSION["message"];
                unset($_SESSION["message"])
                ?>
        </span>
        <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>
    <form class="register-form" action="index.php" method="POST">
        <div class="form-group my-2">
            <label for="username">Username*</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
                value="<?php echo $username ?>" />
            <span class="text-danger "><?php echo $usernameError; ?></span>
        </div>
        <div class="form-group my-2">
            <label for="email">Email address*</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email"
                value="<?php echo $email; ?>" />
            <span class="text-danger"><?php echo $emailError;  ?></span>
        </div>
        <div class="form-group my-2">
            <label for="email">Phone</label>
            <input inputmode="numeric" class="form-control" id="phoneNumber" name="phoneNumber"
                placeholder="Enter phone (Optional)" value="<?php echo $phoneNumber ?>" />
            <span class="text-danger"><?php echo $phoneNumberError; ?></span>
        </div>
        <div class="form-group my-2">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location"
                placeholder="Enter location (Optional)" value="<?php echo $location ?>" />
            <span class="text-danger"><?php echo $locationError; ?></span>
        </div>
        <div class="form-group my-2">
            <label for="passowrd">Password*</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="password" />
            <span class="text-danger error-password"><?php echo $passwordError; ?></span>
        </div>
        <div class="form-group my-2">
            <label for="confirmPassword">Confirm Password*</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                placeholder="Confirm Password" />
            <span class="text-danger error-cpassword"><?php echo $confirmPasswordError; ?></span>
        </div>
        <button type="submit" class="btnRegister btn btn-primary btn-sm" name="register">
            Sign Up
        </button>
        <div class="text-center my-2 separator-icon">----- OR -----</div>
        <button type="submit" class="btn btn-primary btn-sm w-100">
            <i class="fab fa-google me-1"></i> Login with Google
        </button>
        <div class="lead my-2 link-container">Already a member? <a class="m-1 login-link text-primary"
                href="includes/login.php">Sign in</a>
        </div>
    </form>
</div>