<?php
session_start();

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "m.i.a";

$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);


if(isset($_GET['confirm'])){
    $order_id = intval($_GET['confirm']);
    $stmt = $conn->prepare("UPDATE orders SET order_status='Confirmed' WHERE order_numbers=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    header("Location: admin_dashboard.php");
    exit;
}


if(isset($_POST['add_product'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_link = $_POST['image_link'];

    $stmt = $conn->prepare("INSERT INTO `product` (Product_id, product_name, price, description, image_link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $product_id, $product_name, $price, $description, $image_link);
    if($stmt->execute()){
        $message = "Product added successfully!";
    } else {
        $message = "Error: ".$stmt->error;
    }
}


$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$totalRevenue = $conn->query("
    SELECT SUM(p.price * od.quantity) AS total_revenue
    FROM `order details table` od
    JOIN `product` p ON od.product_id = p.Product_id
")->fetch_assoc()['total_revenue'] ?? 0;


$orders_result = $conn->query("SELECT * FROM orders ORDER BY order_numbers DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:0; padding:0; display:flex; background:#ffe6f0; }
.sidebar { width:280px; background:#ff4da6; color:white; height:100vh; padding:20px; box-sizing:border-box; border-radius:0 20px 20px 0; position:relative; }
.sidebar h2 { margin-top:0; font-size:24px; }
.sidebar ul { list-style:none; padding:0; }
.sidebar li { margin:15px 0; }
.sidebar a { color:white; text-decoration:none; font-size:18px; display:flex; align-items:center; }
.sidebar a::before { content:'●'; margin-right:10px; color:#fff0f5; }
.account-icon { position:absolute; bottom:20px; left:20px; font-size:48px; color:white; }
.account-icon span { margin-left:10px; font-size:18px; font-weight:bold; }
.main { flex:1; padding:20px; }
.header { background:#ff4da6; padding:20px; border-radius:10px; margin-bottom:20px; }
.header h1 { margin:0; color:white; }
.dashboard-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px; }
.card { background:#fff0f5; border:2px solid #ffb3d9; padding:20px; border-radius:15px; }
.large-card { grid-column: span 2; }
.bar-graph { width:100%; height:200px; background:#ffe6f0; border-radius:10px; padding:10px; }
.bar { fill:#ff4da6; }
.bar:hover { fill:#e60073; }
form { background:#fff0f5; padding:20px; border-radius:10px; margin-top:20px; }
input, button, textarea { padding:8px; margin:5px; border-radius:5px; border:none; width: calc(100% - 16px); }
button { background:#ff4da6; color:white; cursor:pointer; }
button:hover { background:#e60073; }
.message { margin:10px 0; font-weight:bold; color:green; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
th, td { border:1px solid #ffb3d9; padding:10px; text-align:center; }
a.confirm-btn { color:white; background:#ff4da6; padding:5px 10px; border-radius:5px; text-decoration:none; }
a.confirm-btn:hover { background:#e60073; }
</style>
</head>

<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="homepage.php">Homepage</a></li>
    </ul>
    <div class="account-icon">
        <i class="fas fa-user-circle"></i>
    </div>
</div>

<div class="main">
    <div class="header">
        <h1>MIA Admin Dashboard</h1>
    </div>

    <div class="dashboard-grid">
        <div class="card"><h3>Total Users</h3><p><?php echo $totalUsers; ?></p></div>
        <div class="card"><h3>Total Orders</h3><p><?php echo $totalOrders; ?></p></div>
        <div class="card"><h3>Revenue (₱)</h3><p><?php echo number_format($totalRevenue,2); ?></p></div>
        <div class="card large-card">
            <h3>Revenue Graph (Sample)</h3>
            <svg class="bar-graph" viewBox="0 0 400 200">
                <rect class="bar" x="20" y="120" width="40" height="80"></rect>
                <rect class="bar" x="80" y="100" width="40" height="100"></rect>
                <rect class="bar" x="140" y="80" width="40" height="120"></rect>
                <rect class="bar" x="200" y="60" width="40" height="140"></rect>
                <rect class="bar" x="260" y="40" width="40" height="160"></rect>
                <rect class="bar" x="320" y="20" width="40" height="180"></rect>
            </svg>
        </div>
    </div>

    
    <form method="post">
        <h3>Add New Product</h3>
        <?php if(isset($message)) echo "<div class='message'>".$message."</div>"; ?>
        <input type="text" name="product_id" placeholder="Product ID" required>
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        <input type="text" name="image_link" placeholder="Image Link" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    
    <div class="card large-card">
        <h3>Pending Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while($order = $orders_result->fetch_assoc()): ?>
            <tr>
                <td>#<?= $order['order_numbers'] ?></td>
                <td><?= htmlspecialchars($order['user_name']) ?></td>
                <td><?= $order['order_status'] ?></td>
                <td>
                    <?php if($order['order_status'] == 'Processing'): ?>
                        <a class="confirm-btn" href="admin_dashboard.php?confirm=<?= $order['order_numbers'] ?>">Confirm</a>
                    <?php else: ?>
                        Confirmed
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</body>
</html>
