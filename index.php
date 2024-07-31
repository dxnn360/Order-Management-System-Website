<?php
include 'db_connect.php';

$sql = "SELECT * FROM orders ORDER BY pickup_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Daftar Pesanan</h2>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Nama Customer</th>
                    <th>Tanggal Order</th>
                    <th>Tanggal Diambil</th>
                    <th>Ukuran Badan</th>
                    <th>Harga</th>
                    <th>Catatan</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["customer_name"] . "</td>";
                        echo "<td>" . $row["order_date"] . "</td>";
                        echo "<td>" . $row["pickup_date"] . "</td>";
                        echo "<td>" . $row["size"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["notes"] . "</td>";
                        echo "<td><img src='" . $row["image_path"] . "' width='100'></td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td><a href='edit_order.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm btn-action'>Edit</a> <a href='delete_order.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm btn-action'>Hapus</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
