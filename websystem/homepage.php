<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location:index.php"); exit; }

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$products=$conn->query("SELECT * FROM `product table`");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Shop - M.I.A</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:white;padding:15px;text-align:center;}
.product{display:flex;flex-wrap:wrap;gap:20px;justify-content:center;margin:20px;}
.card{background:#fff0f5;padding:15px;border-radius:10px;width:200px;text-align:center;}
button,a.button{padding:10px 15px;background:#ff4da6;color:white;text-decoration:none;border:none;border-radius:5px;cursor:pointer;}
button:hover,a.button:hover{background:#e60073;}
</style>
</head>
<body>
<header>
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<p>
<a href="cart.php" class="button">Cart</a> | 
<a href="order_history.php" class="button">Order History</a> | 
<a href="track_order.php" class="button">Track Order</a> | 
<?php if($_SESSION['is_admin']==1) echo '<a href="admin_dashboard.php" class="button">Admin</a>'; ?>
<a href="index.php" class="button">Logout</a>
</p>
</header>
<div class="product">
<?php while($p=$products->fetch_assoc()): ?>
<div class="card">
<h3><?php echo htmlspecialchars($p['product_name']); ?></h3>
<p>₱<?php echo number_format($p['price'],2); ?></p>
<form method="post" action="cart.php">
<input type="hidden" name="pid" value="<?php echo $p['Product_id']; ?>">
<input type="number" name="qty" value="1" min="1" style="width:60px;"><br><br>
<button type="submit" name="add_to_cart">Add to Cart</button>
</form>
</div>
<?php endwhile; ?>
</div>
</body>
</html>
