<?php
session_start();
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']!=1) header("Location:homepage.php");

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if(isset($_POST['add_product'])){
    $id=$_POST['product_id']; $name=$_POST['product_name']; $price=$_POST['price'];
    $stmt=$conn->prepare("INSERT INTO `product table` (Product_id,product_name,price) VALUES (?,?,?)");
    $stmt->bind_param("sss",$id,$name,$price); $stmt->execute();
}

if(isset($_GET['delete'])){
    $pid=$_GET['delete'];
    $stmt=$conn->prepare("DELETE FROM `product table` WHERE Product_id=?");
    $stmt->bind_param("s",$pid); $stmt->execute();
}

$products=$conn->query("SELECT * FROM `product table`")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Products</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
table{width:80%;margin:20px auto;border-collapse:collapse;background:#fff0f5;}
th,td{padding:10px;border:1px solid #ffb3d9;text-align:center;}
form{max-width:600px;margin:20px auto;padding:20px;background:#fff0f5;border-radius:10px;}
input{padding:8px;margin:5px;}
button{padding:8px 12px;background:#ff4da6;color:#fff;border:none;border-radius:5px;cursor:pointer;}
button:hover{background:#e60073;}
a{color:#e60073;text-decoration:none;}
</style>
</head>
<body>
<header>
<h1>Manage Products</h1>
<p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</header>
<form method="post">
<h3>Add New Product</h3>
<input type="text" name="product_id" placeholder="Product ID" required>
<input type="text" name="product_name" placeholder="Product Name" required>
<input type="text" name="price" placeholder="Price" required>
<button type="submit" name="add_product">Add Product</button>
</form>
<table>
<tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
<?php foreach($products as $p): ?>
<tr>
<td><?=$p['Product_id']?></td>
<td><?=$p['product_name']?></td>
<td>₱<?=$p['price']?></td>
<td><a href="?delete=<?=$p['Product_id']?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
