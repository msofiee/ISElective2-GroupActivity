<?php
session_start();
if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']!=1) header("Location:homepage.php");

$host="127.0.0.1"; $user="root"; $pass=""; $db="m.i.a";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if(isset($_POST['add_product'])){
    $id=$_POST['product_id']; $name=$_POST['product_name']; $price=$_POST['price'];
    $stmt=$conn->prepare("INSERT INTO `product_table` (Product_id,product_name,price) VALUES (?,?,?)");
    $stmt->bind_param("sss",$id,$name,$price); $stmt->execute();
}

if(isset($_GET['delete'])){
    $pid=$_GET['delete'];
    $stmt=$conn->prepare("DELETE FROM `product_table` WHERE Product_id=?");
    $stmt->bind_param("s",$pid); $stmt->execute();
}

$products=$conn->query("SELECT * FROM `product_table`")->fetch_all(MYSQLI_ASSOC);
?>

