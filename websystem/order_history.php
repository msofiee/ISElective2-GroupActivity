<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location:index.php"); exit; }

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$username=$_SESSION['username'];
$stmt=$conn->prepare("SELECT * FROM `orders` WHERE user_name=? ORDER BY order_numbers DESC");
$stmt->bind_param("s",$username);
$stmt->execute();
$result=$stmt->get_result();
$orders=$result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order History - M.I.A</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
table{width:80%;margin:20px auto;border-collapse:collapse;background:#fff0f5;}
th,td{padding:12px;border:1px solid #ffb3d9;text-align:center;}
a{color:#e60073;text-decoration:none;}
a.button{padding:8px 12px;background:#ff4da6;color:#fff;border-radius:5px;text-decoration:none;}
a.button:hover{background:#e60073;}
</style>
</head>
<body>
<header>
<h1>Order History</h1>
<p><a href="homepage.php" class="button">Back to Shop</a> | <a href="track_order.php" class="button">Track Last Order</a></p>
</header>
<?php if(count($orders)==0): ?>
<p style="text-align:center;">No past orders found.</p>
<?php else: ?>
<table>
<tr><th>Order ID</th><th>Items</th><th>Quantity</th><th>Status</th></tr>
<?php foreach($orders as $order):
    $elapsed=time()-strtotime($order['order_date']??date('Y-m-d H:i:s'));
    if($elapsed<10) $status="Processing";
    elseif($elapsed<20) $status="Shipped";
    elseif($elapsed<30) $status="Out for Delivery";
    else $status="Delivered";
?>
<tr>
<td><?php echo $order['order_numbers']; ?></td>
<td><?php echo htmlspecialchars($order['Items']); ?></td>
<td><?php echo $order['quantity']; ?></td>
<td><?php echo $status; ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</body>
</html>
