<?php if (isset($_POST["resetPassword"])) {
?>
<div class="d-flex justify-content-between alert alert-<?php echo $_SESSION["msg-type"]; ?> ">
    <span>
        <?php
            echo $_SESSION["message"];
            unset($_SESSION["message"])
            ?>
    </span>
    <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
</div>
<?php } ?>