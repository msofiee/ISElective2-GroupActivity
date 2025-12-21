<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location:index.php");
    exit;
}

$host="127.0.0.1";
$user="root";
$pass="";
$db="m.i.a";

$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

$username = $_SESSION['username'];
    
$sql = "
SELECT 
    o.order_numbers,
    o.Items,
    o.quantity,
    u.address,
    u.user_name
FROM orders o
JOIN users u ON u.user_name = o.user_name
WHERE o.user_name = ?
ORDER BY o.order_numbers DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order History - M.I.A</title>

<style>
body{
    font-family:Arial;
    background:#ffe6f0;
    margin:0;
}
header{
    background:#ff4da6;
    color:white;
    padding:15px;
    text-align:center;
}
table{
    width:90%;
    margin:20px auto;
    border-collapse:collapse;
    background:#fff0f5;
}
th,td{
    padding:12px;
    border:1px solid #ffb3d9;
    text-align:center;
}
th{
    background:#ff4da6;
    color:white;
}
.button{
    padding:8px 12px;
    background:#ff4da6;
    color:white;
    border-radius:5px;
    text-decoration:none;
}
.button:hover{
    background:#e60073;
}
</style>
</head>

<body>

<header>
    <h1>Order History</h1>
    <p>
        <a href="homepage.php" class="button">Back to Shop</a>
        <a href="track_order.php" class="button">Track Order</a>
    </p>
    
</header>

<?php if(empty($orders)): ?>
    <p style="text-align:center;">No orders found.</p>
<?php else: ?>

<table>
<tr>
    <th>Order ID</th>
    <th>Username</th>
    <th>Address</th>
    <th>Items</th>
    <th>Total Quantity</th>
</tr>

<?php foreach($orders as $order): ?>
<tr>
    <td><?= $order['order_numbers']; ?></td>
    <td><?= htmlspecialchars($order['user_name']); ?></td>
    <td><?= htmlspecialchars($order['address']); ?></td>
    <td><?= htmlspecialchars($order['Items']); ?></td>
    <td><?= $order['quantity']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php endif; ?>

</body>
</html>