<?php
session_start();
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']!=1) header("Location:homepage.php");
$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$orders=$conn->query("SELECT * FROM orders ORDER BY order_numbers DESC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Orders</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
table{width:80%;margin:20px auto;border-collapse:collapse;background:#fff0f5;}
th,td{padding:10px;border:1px solid #ffb3d9;text-align:center;}
a{color:#e60073;text-decoration:none;}
</style>
</head>
<body>
<header>
<h1>Manage Orders</h1>
<p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</header>
<table>
<tr><th>Order ID</th><th>User</th><th>Items</th><th>Quantity</th></tr>
<?php foreach($orders as $o): ?>
<tr>
<td><?=$o['order_numbers']?></td>
<td><?=$o['user_name']?></td>
<td><?=$o['Items']?></td>
<td><?=$o['quantity']?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
