<?php
session_start();
if(!isset($_SESSION['username'])){ 
    header("Location:index.php"); 
    exit; 
}

if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];

$products = [
    1=>['name'=>'White Leather Sandals','price'=>359,'img'=>'WHITE SANDALS.jpg','desc'=>'Comfortable loafers, sizes 7-13. Perfect for casual wear.'],
    2=>['name'=>'Elegant Red High Heels','price'=>1200,'img'=>'RED CLASSY HIGH HEELS.jpg','desc'=>'Leather pair with 3-inch heel, sizes 5-11. Ideal for parties or work.'],
    3=>['name'=>'Hiking Boots','price'=>5599,'img'=>'HIKING BOOTS.jpg','desc'=>'Waterproof pair, sizes 7-13. Built for trails and tough terrains.'],
    4=>['name'=>'Elegant Nude High Heels','price'=>1200,'img'=>'NUDE CLASSY HIGH HEELS.jpg','desc'=>'Leather pair with 3-inch heel, sizes 5-11. Ideal for parties or work.'],
    5=>['name'=>'Doll Shoes','price'=>269,'img'=>'DOLLSHOES.jpg','desc'=>'Casual and Comfortable for everyday use, sizes 7-11.'],
    6=>['name'=>'Formal Sandals','price'=>359,'img'=>'FORMAL SANDALS.jpg','desc'=>'Casual, sizes 7-11. Ideal for work.'],
    7=>['name'=>'Black Flat Sandals','price'=>235,'img'=>'BLACK FLAT SANDALS.jpg','desc'=>'Lightweight everyday, sizes 6-11.'],
    8=>['name'=>'Black Leather Sandals','price'=>359,'img'=>'BLACK LEATHER SANDALS.jpg','desc'=>'Comfortable loafers, sizes 7-13. Perfect for casual wear.'],
    9=>['name'=>'Brown Leather Sandals','price'=>359,'img'=>'BROWN LEATHER SANDALS.jpg','desc'=>'Comfortable loafers, sizes 7-13. Perfect for casual wear.'],
];

if(isset($_POST['add_to_cart'])){
    $pid=intval($_POST['pid']);
    if(isset($products[$pid])){
        if(isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid]++;
        else $_SESSION['cart'][$pid]=1;
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Shop - M.I.A</title>
<style>
body{font-family:Arial;background:#ffe6f0;margin:0;}
header{background:#ff4da6;color:white;padding:15px;text-align:center;position:relative;}
button,a.button{padding:10px 15px;background:#ff4da6;color:white;text-decoration:none;border:none;border-radius:5px;cursor:pointer;}
button:hover,a.button:hover{background:#e60073;}

.product-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:25px;padding:20px;}
.product-card{background:#ffe6f0;border-radius:15px;padding:20px;text-align:center;box-shadow:0 8px 20px rgba(255,105,180,0.2);transition:transform 0.3s,box-shadow 0.3s;}
.product-card:hover{transform: translateY(-5px);}
.product-card img{width:100%; height:100px; object-fit:cover; border-radius:10px; margin-bottom:15px;}
.product-card h3{color:#d63384;margin-bottom:8px;font-size:20px;}
.product-card p{font-size:0.95rem;margin-bottom:8px;}

.cart-count{position:absolute;top:10px;right:10px;background:#fff;color:#ff4da6;padding:5px 10px;border-radius:20px;border:2px solid #ff4da6;}


.admin-btn{
    position:absolute;
    top:15px;
    left:15px;
    width:35px;
    height:35px;
    background:#ff4da6;
    color:white;
    border-radius:50%;
    text-align:center;
    line-height:35px;
    font-weight:bold;
    font-size:18px;
    text-decoration:none;
    box-shadow:0 4px 8px rgba(0,0,0,0.2);
    transition:background 0.3s, transform 0.3s;
}
.admin-btn:hover{
    background:#e60073;
    transform:translateY(-2px);
}
</style>
</head>
<body>

<header>
    
    <a href="admin_dashboard.php" class="admin-btn">A</a>

    <h1>Welcome, <?=htmlspecialchars($_SESSION['username'])?></h1>
    <p>
        <a href="cart.php" class="button">Cart (<?=array_sum($_SESSION['cart'])?>)</a> | 
        <a href="order_history.php" class="button">Order History</a> | 
        <a href="track_order.php" class="button">Track Order</a> | 
        <a href="index.php" class="button">Logout</a>
    </p>
</header>

<div class="product-grid">
<?php foreach($products as $id=>$p): ?>
<div class="product-card">
    <img src="<?=$p['img']?>" alt="<?=htmlspecialchars($p['name'])?>">
    <h3><?=htmlspecialchars($p['name'])?></h3>
    <p><?=$p['desc']?></p>
    <p><strong>₱<?=number_format($p['price'],2)?></strong></p>
    <form method="post">
        <input type="hidden" name="pid" value="<?=$id?>">
        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>
</div>
<?php endforeach; ?>
</div>

</body>
</html>
