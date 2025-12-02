<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location:index.php"); exit; }

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$cartItems=[];
$total=0;

if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
    $ids=array_keys($_SESSION['cart']);
    $placeholders=implode(',', array_fill(0,count($ids),'?'));
    $stmt=$conn->prepare("SELECT * FROM `product table` WHERE Product_id IN ($placeholders)");
    $types=str_repeat('s', count($ids));
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $res=$stmt->get_result();
    while($row=$res->fetch_assoc()){
        $pid=$row['Product_id'];
        $row['quantity']=$_SESSION['cart'][$pid];
        $row['subtotal']=$row['quantity']*$row['price'];
        $total+=$row['subtotal'];
        $cartItems[]=$row;
    }
}

if(isset($_POST['confirm_order']) && count($cartItems)>0){
    $username=$_SESSION['username'];
    $order_id=rand(1000,9999);
    $timestamp=time();

    $items_str=[];
    foreach($cartItems as $item){
        $items_str[]=$item['product_name'].' x'.$item['quantity'];
    }
    $items=implode(', ', $items_str);

    $stmt=$conn->prepare("INSERT INTO `orders` (customer_name, address, email, user_name, password, Items, quantity) VALUES (?,?,?,?,?,?,?)");
    $customer_name=$_SESSION['username'];
    $address='N/A';
    $email='N/A';
    $password='N/A';
    $quantity=array_sum(array_column($cartItems,'quantity'));
    $stmt->bind_param("ssssssi",$customer_name,$address,$email,$username,$password,$items,$quantity);
    $stmt->execute();

    unset($_SESSION['cart']);
    $msg="Order confirmed! Thank you, $username.";
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
button{padding:10px 15px;background:#ff4da6;color:#fff;border:none;border-radius:5px;cursor:pointer;}
button:hover{background:#e60073;}
a{color:#e60073;text-decoration:none;}
</style>
</head>
<body>
<header>
<h1>Checkout</h1>
<p><a href="cart.php">Back to Cart</a> | <a href="homepage.php">Back to Shop</a></p>
</header>
<div class="checkout">
<?php if(isset($msg)) echo "<p style='color:green;font-weight:bold;'>$msg</p>"; ?>

<?php if(count($cartItems)>0): ?>
<table>
<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
<?php foreach($cartItems as $item): ?>
<tr>
<td><?php echo htmlspecialchars($item['product_name']); ?></td>
<td>₱<?php echo number_format($item['price'],2); ?></td>
<td><?php echo $item['quantity']; ?></td>
<td>₱<?php echo number_format($item['subtotal'],2); ?></td>
</tr>
<?php endforeach; ?>
<tr><th colspan="3">Total</th><th>₱<?php echo number_format($total,2); ?></th></tr>
</table>
<form method="post">
<button type="submit" name="confirm_order">Confirm Purchase</button>
</form>
<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>
</div>
</body>
</html>
