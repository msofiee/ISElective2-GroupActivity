<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location:index.php"); exit; }

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);
$username=$_SESSION['username'];
$stmt=$conn->prepare("SELECT * FROM `orders` WHERE user_name=? ORDER BY order_numbers DESC LIMIT 1");
$stmt->bind_param("s",$username);
$stmt->execute();
$order=$stmt->get_result()->fetch_assoc();
$status="No orders yet";

if($order){
    $elapsed=time()-strtotime($order['order_date']??date('Y-m-d H:i:s'));
    if($elapsed<10) $status="Processing";
    elseif($elapsed<20) $status="Shipped";
    elseif($elapsed<30) $status="Out for Delivery";
    else $status="Delivered";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Track Order - M.I.A</title>
<meta http-equiv="refresh" content="5">
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
.checkout{max-width:800px;margin:20px auto;background:#fff0f5;padding:20px;border-radius:10px;}
table{width:100%;border-collapse:collapse;margin-bottom:20px;}
th,td{padding:10px;border:1px solid #ffb3d9;text-align:center;}
.status{font-weight:bold;color:#e60073;}
a{text-decoration:none;color:#e60073;}
</style>
</head>
<body>
<header>
<h1>Track Your Order</h1>
<p><a href="homepage.php">Back to Products</a></p>
</header>
<div class="checkout">
<?php if(!$order): ?>
<p>No recent orders found.</p>
<?php else: ?>
<h2>Order Details</h2>
<p>Order ID: <strong>#<?php echo $order['order_numbers']; ?></strong></p>
<p>Customer: <strong><?php echo htmlspecialchars($order['user_name']); ?></strong></p>
<p>Status: <span class="status"><?php echo $status; ?></span></p>
<table>
<tr><th>Items</th><th>Quantity</th></tr>
<tr>
<td><?php echo htmlspecialchars($order['Items']); ?></td>
<td><?php echo $order['quantity']; ?></td>
</tr>
</table>
<p>Your order is currently <strong><?php echo $status; ?></strong>.</p>
<p>This page refreshes every 5 seconds.</p>
<?php endif; ?>
</div>
</body>
</html>
