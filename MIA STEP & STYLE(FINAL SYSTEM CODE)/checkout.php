<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location:index.php"); exit; }

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$products = [
    1=>['name'=>'White Leather Sandals','price'=>359],
    2=>['name'=>'Elegant Red High Heels','price'=>1200],
    3=>['name'=>'Hiking Boots','price'=>5599],
    4=>['name'=>'Elegant Nude High Heels','price'=>1200],
    5=>['name'=>'Doll Shoes','price'=>269],
    6=>['name'=>'Formal Sandals','price'=>359],
    7=>['name'=>'Black Flat Sandals','price'=>235],
    8=>['name'=>'Black Leather Sandals','price'=>359],
    9=>['name'=>'Brown Leather Sandals','price'=>359],
];

$msg = '';
if(isset($_POST['place_order'])){
    if(empty($_SESSION['cart'])){
        $msg="Your cart is empty!";
    } else {
        $items=[]; $qty=[]; $total=0;
        foreach($_SESSION['cart'] as $pid=>$count){
            $items[]=$products[$pid]['name'];
            $qty[]=$count;
            $total += $products[$pid]['price']*$count;
        }
        $stmt=$conn->prepare("INSERT INTO orders (user_name,Items,quantity) VALUES (?,?,?)");
        $stmt->bind_param("ssi", $_SESSION['username'], implode(", ", $items), array_sum($qty));
        $stmt->execute();
        $_SESSION['cart']=[];
        $msg="Order placed successfully!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Checkout - M.I.A</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
.checkout{max-width:800px;margin:20px auto;background:#fff0f5;padding:20px;border-radius:10px;}
table{width:100%;border-collapse:collapse;margin-bottom:20px;}
th,td{padding:10px;border:1px solid #ffb3d9;text-align:center;}
button{padding:8px 12px;background:#ff4da6;color:#fff;border:none;border-radius:5px;cursor:pointer;}
button:hover{background:#e60073;}
a{text-decoration:none;color:#e60073;}
</style>
</head>
<body>
<header>
<h1>Checkout</h1>
<p><a href="homepage.php">Back to Shop</a></p>
</header>

<div class="checkout">
<?php if(isset($msg)) echo "<p style='text-align:center;color:green;'>$msg</p>"; ?>

<?php if(empty($_SESSION['cart'])): ?>
<p style="text-align:center;">Your cart is empty.</p>
<?php else: ?>
<h2>Order Summary</h2>
<form method="post">
<table>
<tr><th>Item</th><th>Quantity</th><th>Price</th></tr>
<?php $total=0; foreach($_SESSION['cart'] as $pid=>$qty): 
$price=$products[$pid]['price']*$qty; $total+=$price; ?>
<tr>
<td><?=htmlspecialchars($products[$pid]['name'])?></td>
<td><?=$qty?></td>
<td>₱<?=number_format($price,2)?></td>
</tr>
<?php endforeach; ?>
<tr>
<td colspan="2"><strong>Total</strong></td>
<td>₱<?=number_format($total,2)?></td>
</tr>
</table>
<p style="text-align:center;"><button type="submit" name="place_order">Place Order</button></p>
</form>
<?php endif; ?>
</div>
</body>
</html>
