<?php
require("controllers/process-add-revenue.php");
require("controllers/process-sort-revenues.php");
require("controllers/process-delete-revenue.php");
if (empty($_SESSION["user_id"])) {
    header("location: includes/login.php");
} ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="assets/styles/style.css" />
        <link rel="stylesheet" href="assets/styles/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
            integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm"
            crossorigin="anonymous" />
        <title>Pesa Manager | Revenues</title>
    </head>

    <body>
        <div class="container-fluid bg-img-wrapper vw-100">
            <div class="row">
                <!-- Header -->
                <?php require("includes/header.php"); ?>
                <main class="col-lg-8 main py-1" id="main">
                    <div class="py-4 text-center">
                        <div class="container d-flex justify-content-center flex-column">
                            <?php
                        if (isset($_POST["addRevenue"])) :
                        ?>
                            <div
                                class="d-flex justify-content-between w-100 alert alert-<?php echo $_SESSION['msg-type']; ?> ">
                                <span>
                                    <?php
                                    echo $_SESSION["message"];
                                    unset($_SESSION["message"])
                                    ?>
                                </span>
                                <button class="btn-close ms-2" data-bs-dismiss="alert"></button>
                            </div>
                            <?php endif; ?>
                            <p class="type-title display-6 mb-2">Revenues</p>
                            <!-- Sort By -->
                            <form action="view-sorted-revenue.php" method="POST">
                                <div class="input-group">
                                    <select name="sortRevenue" id="sortRevenue" class="form-select">
                                        <option value="-1" disabled selected>Sort Revenues By</option>
                                        <option value="all">All</option>
                                        <option value="today">Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="week">Weekly</option>
                                        <option value="month1">1 Month</option>
                                        <option value="month3">3 Month</option>
                                        <option value="month6">6 Month</option>
                                        <option value="year">Annually</option>
                                    </select>
                                    <input type="submit" class="btn btn-primary" value="sort" name="sortRevenueBtn">
                                </div>
                            </form>

                            <!-- Display Revenue in the table here -->
                            <div class="table-responsive">
                                <table
                                    class="table table-width table-hover table-bordered table-striped bg-light caption-top my-2 mt-3">
                                    <caption class="top text-light lead h2 text-center">List Of Revenues</caption>
                                    <thead class="bg-dark text-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Revenue</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    if (!$conn) {
                                        echo "Connection Error " . mysqli_connect_error();
                                    } else {
                                        $revenueIndex = 1;
                                        $loggedInUser = $_SESSION["user_id"];
                                        $sqlRevenues = "SELECT revenues.revenue_id, revenues.item, revenues.amount, revenues.date_created FROM revenues INNER JOIN registration ON revenues.user_id = registration.user_id WHERE revenues.user_id = '$loggedInUser'";
                                        $revenueResult = mysqli_query($conn, $sqlRevenues);
                                        if (mysqli_num_rows($revenueResult) > 0) {
                                            while ($revenueRow = mysqli_fetch_assoc($revenueResult)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $revenueIndex++; ?></th>
                                            <td><?php echo $revenueRow["item"]; ?></td>
                                            <td><?php echo $revenueRow["amount"]; ?></td>
                                            <td><?php echo $revenueRow["date_created"]; ?></td>
                                            <td colspan="2" class="d-flex">
                                                <a href="view-revenue.php?view_revenue=<?php echo $revenueRow["revenue_id"]; ?>"
                                                    title="View Revenue"
                                                    class="d-flex mx-1 btn btn-info btn-sm text-light">
                                                    <i class="fas fa-eye me-1"></i><span
                                                        class="action-btn">View</span></a>
                                                <a href="edit-revenue.php?edit_revenue=<?php echo $revenueRow["revenue_id"]; ?>"
                                                    title="Edit Revenue"
                                                    class="d-flex mx-1 btn btn-warning btn-sm text-light">
                                                    <i class="fas fa-edit me-1"></i><span class="action-btn"
                                                        onclick="return confirm('You are about to edit this record. Are you sure?')">Edit</span></a>
                                                <a href="revenues.php?delete_revenue=<?php echo $revenueRow["revenue_id"]; ?>"
                                                    onclick="return confirm('Are you sure you want to delete this record?')"
                                                    title="Delete Revenue"
                                                    class="d-flex mx-1 btn btn-danger btn-sm text-light">
                                                    <i class="fas fa-trash-alt me-1"></i>
                                                    <span class="action-btn">Delete</span></a>
                                            </td>
                                            <?php  ?>
                                        </tr>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <div class="my-2">No records! All revenues will be shown here</div>
                                        <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>


                            <button type="button" data-bs-toggle="modal" data-bs-target="#openRevenueModal"
                                class="btnAddNewRevenue btn text-light" title="Add New Revenue">
                                <span class="btnCategory"> &plus; </span>
                            </button>
                        </div>
                    </div>
                    <!-- Expense Modal -->
                    <div class="modal fade" id="openRevenueModal">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Add New Revenue</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="revenues.php" method="POST">
                                        <div class=" form-group">
                                            <label class="form-label" for="item">Item</label>
                                            <input type="text" class="form-control" id="item" name="revenueItem"
                                                placeholder="Enter an item" />
                                            <span class="text-danger"><?php echo $revenueItemError ?></span>
                                        </div>
                                        <div class="form-group my-2">
                                            <label class="form-label" for="revenueAmount">Amount</label>
                                            <input inputmode="numeric" class="form-control" id="revenueAmount"
                                                name="revenueAmount" placeholder="Amount Spent" />
                                            <span class="text-danger"><?php echo $revenueAmountError ?></span>
                                        </div>
                                        <div class="form-group my-2">
                                            <label class="form-label" for="description">Description</label>
                                            <input type="text" class="form-control" id="description"
                                                name="revenueDescription" placeholder="Describe your revenue" />
                                            <span class="text-danger"><?php echo $revenueDescriptionError ?></span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-secondary" name="btn_close"
                                                data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="addRevenue"
                                                name="addRevenue">Add Revenue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Footer -->
        <?php
    require("includes/footer.php")
    ?>
        <script src="assets/scripts/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/scripts/hamburger.js"></script>
        <!-- <script src="assets/scripts/theme.js"></script> -->
        <script src="assets/scripts/app.js"></script>
    </body>

</html>