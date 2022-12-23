const userTypeSelection = document.querySelector("#userTypeSelection");
userTypeSelection.addEventListener("change", () => {
    let userInput = userTypeSelection.value;
    if (userInput === "-1") {
        window.location.href = ""
    } else if (userInput === "expense") {
        window.location.href = "expenditures.php";
    } else {
        window.location.href = "revenues.php";
    }
})