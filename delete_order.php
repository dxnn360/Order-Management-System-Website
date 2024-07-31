<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $sql = "DELETE FROM orders WHERE id = $order_id";

    if ($conn->query($sql) === TRUE) {
        echo "Order deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
