<div class="container mt-1">
    <?php require("includes/sort-revenue-header-details.php") ?>
    <table class="table table-width table-hover table-striped bg-light caption-top my-2 mt-3">
        <caption class="top text-dark display-6 text-center">Revenues Report Form Yesterday (
            <?php
            $yesterday = strtotime("yesterday");
            echo date("d/m/Y", $yesterday);
            ?>
            )</caption>
        <thead class="bg-dark text-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Revenue</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col" class="not-print">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $activeUser = $_SESSION["user_id"];
            $sqlYesterday = "SELECT * FROM revenues INNER JOIN registration ON revenues.user_id = registration.user_id WHERE revenues.user_id = '$activeUser' AND revenues.date_created BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 DAY) AND CURDATE()";
            $yesterdayResult = mysqli_query($conn, $sqlYesterday);

            if (mysqli_num_rows($yesterdayResult) > 0) {
                $revenueIndex = 1;
                $sumRevenues = 0;
                while ($rowYesterday = mysqli_fetch_assoc($yesterdayResult)) {
                    $sumRevenues += $rowYesterday["amount"];
            ?>

            <tr>
                <th scope="row"><?php echo $revenueIndex++; ?></th>
                <td><?php echo $rowYesterday["item"]; ?></td>
                <td><?php echo $rowYesterday["amount"]; ?></td>
                <td><?php echo $rowYesterday["date_created"]; ?></td>
                <td><?php echo $rowYesterday["revenue_description"]; ?></td>
                <td colspan="2" class="not-print d-flex">
                    <a href="view-revenue.php?view_revenue=<?php echo $rowYesterday["revenue_id"]; ?>"
                        title="View Revenue" class="d-flex mx-1 btn btn-info text-light">
                        <i class="fas fa-eye me-1"></i><span class="action-btn">View</span></a>
                    <a href="edit-revenue.php?edit_revenue=<?php echo $rowYesterday["revenue_id"]; ?>"
                        onclick="return confirm('You are about to edit this record. Are you sure?')"
                        title="Edit Revenue" class="d-flex mx-1 btn btn-success text-light">
                        <i class="fas fa-edit me-1"></i><span class="action-btn">Edit</span></a>
                    <a href="revenues.php?delete_revenue=<?php echo $rowYesterday["revenue_id"]; ?>"
                        onclick=" return confirm('Are you sure you want to delete this record?')" title="Delete Revenue"
                        class="d-flex mx-1 btn btn-danger text-light">
                        <i class="fas fa-trash-alt me-1"></i>
                        <span class="action-btn">Delete</span></a>
                </td>
            </tr>
            <?php } ?>
            <tr class="bg-secondary text-light display-6">
                <td colspan="6" class="total-revenue-label">Total Revenue: <?php echo $sumRevenues; ?></td>
            </tr>
            <?php } else { ?>
            <div class="alert alert-info">
                <span>No record for yesterday.</span>
                <button class="btn-close ms-2" data-bs-dismiss="alert" title="Close"></button>
            </div>
            <?php } ?>
        </tbody>
    </table>
</div>