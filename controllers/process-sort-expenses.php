<?php

if (empty($_SESSION["user_id"])) {
    header("location: includes/login.php");
}

if (isset($_POST["sortExpenseBtn"]) && isset($_SESSION["user_id"])) {
    $activeUser = $_SESSION["user_id"];
    $selectedTimeFrame = $_POST["sortExpense"];

    if ($selectedTimeFrame == "all") {
        require("sort-expense/process-sort-all.php");
    } elseif ($selectedTimeFrame == "today") {
        require("sort-expense/process-sort-today.php");
    } elseif ($selectedTimeFrame == "yesterday") {
        require("sort-expense/process-sort-yesterday.php");
    } elseif ($selectedTimeFrame == "week") {
        require("sort-expense/process-sort-week.php");
    } elseif ($selectedTimeFrame == "month1") {
        require("sort-expense/process-sort-month.php");
    } elseif ($selectedTimeFrame == "month3") {
        require("sort-expense/process-sort-month3.php");
    } elseif ($selectedTimeFrame == "month6") {
        require("sort-expense/process-sort-month6.php");
    } elseif ($selectedTimeFrame == "year") {
        require("sort-expense/process-sort-year.php");
    }
}