<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date_opening = $_POST['date_opening'];
	$date_empty = $_POST['date_empty'];

    $sql = "INSERT INTO flasa (name, date opening, date empty) VALUES ('$name', '$date_opening'. '$date_empty)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
