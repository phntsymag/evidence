<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$id = $name = $dateOpening = $dateEmpty = $dateCreated = "";
$id_err = $name_err = $dateOpening_err = $dateEmpty_err = $dateCreated_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "zapis nazov alkoholu";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM flasa WHERE name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set parameters
            $param_name = trim($_POST["name"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $name_err = "This name is already taken.";
                } else {
                    $name = trim($_POST["name"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Check input errors before inserting in the database
    if (empty($name_err) && empty($dateOpening_err) && empty($dateEmpty_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO flasa (name, dateOpening, dateEmpty) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_dateOpening, $param_dateEmpty);

            // Set parameters
            $param_name = $name;
            $param_dateOpening = $_POST['dateOpening'];  // Use the correct variable
            $param_dateEmpty = $_POST['dateEmpty'];  // Use the correct variable

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: invitePage.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Fill Data</h2>
        <p>Please fill this form </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Nazov</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Datum otvorenia</label>
                <input type="date" name="dateOpening" class="form-control" value="<?php echo $dateOpening; ?>">
                <span class="help-block"><?php echo $dateOpening_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($dateEmpty_err)) ? 'has-error' : ''; ?>">
                <label>Datum minutia</label>
                <input type="date" name="dateEmpty" class="form-control" value="<?php echo $meno; ?>">
                <span class="help-block"><?php echo $dateEmpty_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">

            </div>

        </form>
    </div>
</body>

</html>