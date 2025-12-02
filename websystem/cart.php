<?php
session_start();
if(!isset($_SESSION['username'])){ header("Location:index.php"); exit; }

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];

if(isset($_POST['add_to_cart'])){
    $pid=$_POST['pid'];
    $qty=(int)$_POST['qty'];
    if(isset($_SESSION['cart'][$pid])){
        $_SESSION['cart'][$pid]+=$qty;
    } else {
        $_SESSION['cart'][$pid]=$qty;
    }
    header("Location: cart.php"); exit;
}

if(isset($_POST['update_cart'])){
    foreach($_POST['qty'] as $pid=>$q){
        $q=(int)$q;
        if($q<=0) unset($_SESSION['cart'][$pid]);
        else $_SESSION['cart'][$pid]=$q;
    }
    header("Location: cart.php"); exit;
}

if(isset($_GET['remove'])){
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php"); exit;
}
if(isset($_GET['clear'])){
    $_SESSION['cart']=[];
    header("Location: cart.php"); exit;
}

$cartItems=[];
$total=0;
if(count($_SESSION['cart'])>0){
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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cart - M.I.A</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
table{width:80%;margin:20px auto;border-collapse:collapse;background:#fff0f5;}
th,td{padding:12px;border:1px solid #ffb3d9;text-align:center;}
button,a.button{padding:10px 15px;background:#ff4da6;color:white;border:none;border-radius:5px;cursor:pointer;text-decoration:none;}
button:hover,a.button:hover{background:#e60073;}
.actions{text-align:center;margin:20px;}
</style>
</head>
<body>
<header>
<h1>Your Shopping Cart</h1>
<p>
<a href="homepage.php" class="button">Back to Shop</a>
<a href="?clear=1" class="button" style="background:#cc0052;">Clear Cart</a>
</p>
</header>

<?php if(count($cartItems)>0): ?>
<form method="post">
<table>
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
<th>Remove</th>
</tr>
<?php foreach($cartItems as $item): ?>
<tr>
<td><?php echo htmlspecialchars($item['product_name']); ?></td>
<td>₱<?php echo number_format($item['price'],2); ?></td>
<td><input type="number" name="qty[<?php echo $item['Product_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" style="width:60px;"></td>
<td>₱<?php echo number_format($item['subtotal'],2); ?></td>
<td><a href="?remove=<?php echo $item['Product_id']; ?>" class="button">X</a></td>
</tr>
<?php endforeach; ?>
<tr>
<td colspan="3"><strong>Total</strong></td>
<td colspan="2"><strong>₱<?php echo number_format($total,2); ?></strong></td>
</tr>
</table>
<div class="actions">
<button type="submit" name="update_cart">Update Cart</button>
<a href="checkout.php" class="button">Proceed to Checkout</a>
</div>
</form>
<?php else: ?>
<h2 style="text-align:center;">Your cart is empty.</h2>
<p style="text-align:center;"><a href="homepage.php" class="button">Shop Now</a></p>
<?php endif; ?>
</body>
</html>
