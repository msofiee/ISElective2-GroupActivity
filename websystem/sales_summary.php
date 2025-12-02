<?php
session_start();
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']!=1) header("Location:homepage.php");

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$sales=$conn->query("SELECT SUM(quantity*price) AS total FROM orders o JOIN `product table` p ON o.Items LIKE CONCAT('%',p.product_name,'%')")->fetch_assoc()['total']??0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sales Summary</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
.summary{max-width:800px;margin:20px auto;background:#fff0f5;padding:20px;border-radius:10px;text-align:center;}
</style>
</head>
<body>
<header>
<h1>Sales Summary</h1>
<p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</header>
<div class="summary">
<h2>Total Sales</h2>
<p style="font-size:24px; font-weight:bold;">₱<?=number_format($sales,2)?></p>
</div>
</body>
</html>
