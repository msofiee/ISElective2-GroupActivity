<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location:index.php");
    exit;
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

$host="127.0.0.1"; 
$user="root"; 
$pass=""; 
$db="m.i.a";

$conn = new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$products = [];
$result = $conn->query("SELECT * FROM `product`");
while($row = $result->fetch_assoc()){
    $products[$row['Product_id']] = [
        'name' => $row['product_name'],
        'price' => $row['price'],
        'img' => $row['image_link'],
        'desc' => $row['description']
    ];
}


if(isset($_GET['remove'])){
    $rid = intval($_GET['remove']);
    unset($_SESSION['cart'][$rid]);
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Your Cart</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:white;padding:15px;text-align:center;}
table{width:80%;margin:30px auto;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;}
th,td{padding:12px;text-align:center;border-bottom:1px solid #ddd;}
th{background:#ff4da6;color:white;}
a.button,button{padding:8px 14px;background:#ff4da6;color:white;text-decoration:none;border:none;border-radius:5px;cursor:pointer;}
a.button:hover,button:hover{background:#e60073;}
.empty{text-align:center;margin-top:50px;font-size:18px;color:#555;}
img.cart-img{width:80px;height:80px;object-fit:cover;border-radius:5px;}
</style>
</head>
<body>

<header>
    <h1><?=htmlspecialchars($_SESSION['username'])?>'s Cart</h1>
    <a href="homepage.php" class="button">← Continue Shopping</a>
</header>

<?php if(empty($_SESSION['cart'])): ?>

    <div class="empty">
        🛒 Your cart is empty
    </div>

<?php else: ?>

<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
$grandTotal = 0;
foreach($_SESSION['cart'] as $id => $qty):
    if(!isset($products[$id])) continue;
    $total = $products[$id]['price'] * $qty;
    $grandTotal += $total;
?>
<tr>
    <td>
        <?php if(!empty($products[$id]['img'])): ?>
            <img src="<?=htmlspecialchars($products[$id]['img'])?>" alt="<?=htmlspecialchars($products[$id]['name'])?>" class="cart-img">
        <?php endif; ?>
        <?=htmlspecialchars($products[$id]['name'])?>
    </td>
    <td>₱<?=number_format($products[$id]['price'],2)?></td>
    <td><?=$qty?></td>
    <td>₱<?=number_format($total,2)?></td>
    <td><a href="cart.php?remove=<?=$id?>" class="button">Remove</a></td>
</tr>
<?php endforeach; ?>

<tr>
    <th colspan="3">Grand Total</th>
    <th colspan="2">₱<?=number_format($grandTotal,2)?></th>
</tr>
</table>

<div style="text-align:center;margin-bottom:40px;">
    <a href="checkout.php" class="button">Proceed to Checkout</a>
</div>

<?php endif; ?>

</body>
</html>