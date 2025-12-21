<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "m.i.a";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$msg = '';

if (isset($_POST['place_order'])) {
    if (empty($_SESSION['cart'])) {
        $msg = "Your cart is empty!";
    } else {
        $items = [];
        $total_qty = 0;

        foreach ($_SESSION['cart'] as $pid => $count) {
            $stmt = $conn->prepare(
                "SELECT product_name FROM product WHERE Product_id=?"
            );
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($product_name);
            $stmt->fetch();

            if ($stmt->num_rows > 0) {
                $items[] = $product_name . " x" . $count;
                $total_qty += $count;
            }
            $stmt->close();
        }

        $stmt = $conn->prepare(
            "INSERT INTO orders (user_name, Items, quantity) VALUES (?, ?, ?)"
        );
        $items_str = implode(", ", $items);
        $stmt->bind_param("ssi", $_SESSION['username'], $items_str, $total_qty);
        $stmt->execute();
        $stmt->close();

        $_SESSION['cart'] = [];
        $msg = "Order placed successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - M.I.A</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:#fff;padding:15px;text-align:center;}
.checkout{max-width:800px;margin:20px auto;background:#fff0f5;padding:20px;border-radius:10px;}
table{width:100%;border-collapse:collapse;margin-bottom:20px;}
th,td{padding:10px;border:1px solid #ffb3d9;text-align:center;}
img{width:80px;border-radius:8px;}
button{padding:8px 12px;background:#ff4da6;color:#fff;border:none;border-radius:5px;}
</style>
</head>
<body>

<header>
<h1>Checkout</h1>
<p><a href="homepage.php" style="color:white;">Back to Shop</a></p>
</header>

<div class="checkout">
<?php if ($msg) echo "<p style='text-align:center;color:green;'>$msg</p>"; ?>

<?php if (empty($_SESSION['cart'])): ?>
<p style="text-align:center;">Your cart is empty.</p>

<?php else: ?>
<h2>Order Summary</h2>
<form method="post">
<table>
<tr>
    <th>Image</th>
    <th>Item</th>
    <th>Qty</th>
    <th>Price</th>
</tr>

<?php
$total = 0;
foreach ($_SESSION['cart'] as $pid => $qty):
    $stmt = $conn->prepare(
        "SELECT product_name, price, image_link FROM product WHERE Product_id=?"
    );
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($product_name, $price, $image_link);
    $stmt->fetch();

    if ($stmt->num_rows === 0) {
        $stmt->close();
        continue;
    }

    $subtotal = $price * $qty;
    $total += $subtotal;
?>
<tr>
<td><img src="<?= htmlspecialchars($image_link) ?>" alt="product"></td>
<td><?= htmlspecialchars($product_name) ?></td>
<td><?= $qty ?></td>
<td>₱<?= number_format($subtotal, 2) ?></td>
</tr>
<?php
$stmt->close();
endforeach;
?>

<tr>
<td colspan="3"><strong>Total</strong></td>
<td>₱<?= number_format($total, 2) ?></td>
</tr>
</table>

<p style="text-align:center;">
<button type="submit" name="place_order">Place Order</button>
</p>
</form>
<?php endif; ?>
</div>

</body>
</html>
