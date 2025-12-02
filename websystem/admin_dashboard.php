<?php
session_start();
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']!=1){
    header("Location:homepage.php"); exit;
}

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$users=$conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total']??0;
$products=$conn->query("SELECT COUNT(*) AS total FROM `product table`")->fetch_assoc()['total']??0;
$orders=$conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total']??0;
$sales=$conn->query("SELECT SUM(quantity*price) AS sum FROM orders o JOIN `product table` p ON o.Items LIKE CONCAT('%',p.product_name,'%')")->fetch_assoc()['sum']??0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - M.I.A</title>
<style>
body{font-family:Arial;margin:0;background:#ffe6f0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
.dashboard-container{width:80%;margin:20px auto;display:flex;flex-wrap:wrap;gap:20px;}
.box{flex:1 1 calc(25% - 20px);background:white;padding:20px;border-radius:10px;text-align:center;box-shadow:0 0 5px #aaa;}
.box h2{font-size:28px;color:#333;margin:0;}
.box p{color:#555;font-size:18px;}
a.button{display:inline-block;margin-top:10px;padding:10px 15px;background:#ff4da6;color:white;text-decoration:none;border-radius:5px;}
a.button:hover{background:#e60073;}
nav{text-align:center;margin:20px;}
nav a{margin:0 10px;padding:10px 20px;background:#ff4da6;color:white;text-decoration:none;border-radius:5px;}
nav a:hover{background:#e60073;}
</style>
</head>
<body>
<header>
<h1>Admin Dashboard</h1>
<p>Welcome, Admin</p>
</header>
<div class="dashboard-container">
<div class="box"><h2><?=$users?></h2><p>Total Users</p><a href="manage_users.php" class="button">Manage Users</a></div>
<div class="box"><h2><?=$products?></h2><p>Total Products</p><a href="manage_items.php" class="button">Manage Products</a></div>
<div class="box"><h2><?=$orders?></h2><p>Total Orders</p><a href="manage_orders.php" class="button">View Orders</a></div>
<div class="box"><h2>₱<?=number_format($sales,2)?></h2><p>Total Sales</p><a href="sales_summary.php" class="button">Sales Report</a></div>
</div>
<nav>
<a href="homepage.php">Return to Shop</a> | <a href="logout.php">Logout</a>
</nav>
</body>
</html>
