<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $sql = "SELECT * FROM orders WHERE id = $order_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        echo "Order not found.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $order_date = $_POST['order_date'];
    $pickup_date = $_POST['pickup_date'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $notes = $_POST['notes'];
    $image_path = $_POST['current_image'];

    // Upload file gambar baru jika ada
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Error uploading file.";
        }
    }

    $sql = "UPDATE orders SET customer_name='$customer_name', order_date='$order_date', pickup_date='$pickup_date', size='$size', status='$status', price='$price', notes='$notes', image_path='$image_path' WHERE id=$order_id";

    if ($conn->query($sql) === TRUE) {
        echo "Order updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Edit Pesanan</h2>
        <form action="edit_order.php" method="POST" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
            <div class="form-group">
                <label for="customer_name">Nama Customer:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $order['customer_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="order_date">Tanggal Order:</label>
                <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="pickup_date">Tanggal Diambil:</label>
                <input type="date" class="form-control" id="pickup_date" name="pickup_date" value="<?php echo $order['pickup_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="size">Ukuran Badan:</label>
                <textarea class="form-control" id="size" name="size" required><?php echo $order['size']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Harga:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $order['price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="notes">Catatan:</label>
                <textarea class="form-control" id="notes" name="notes"><?php echo $order['notes']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="diproses" <?php echo $order['status'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                    <option value="selesai" <?php echo $order['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Gambar:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <input type="hidden" name="current_image" value="<?php echo $order['image_path']; ?>">
                <?php if ($order['image_path']): ?>
                    <img src="<?php echo $order['image_path']; ?>" width="100" class="mt-2"><br>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Pesanan</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
