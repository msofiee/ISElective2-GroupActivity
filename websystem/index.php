<?php
session_start();

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "m.i.a";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=? OR email=?");
    $stmt->bind_param("ss",$username,$email);
    $stmt->execute();
    if($stmt->get_result()->num_rows > 0){
        $error = "Username or email already exists";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (customer_name, address, email, user_name, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $address, $email, $username, $password);
        $stmt->execute();
        $msg = "Registration successful! Please login.";
    }
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if($result && password_verify($password, $result['password'])){
        // Successful login → go to homepage.php
        session_regenerate_id(true);
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['username'] = $result['user_name'];

        header("Location: homepage.php");  // <<<<<< CONNECTIVE LINK
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>M.I.A Login</title>
<style>
body { font-family: Arial, sans-serif; margin:0; background:#ffe6f0; }
.modal { display:block; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; 
         overflow:auto; background:rgba(255,77,166,0.4); }
.modal-content { background:#fff0f5; margin:10% auto; padding:20px; border-radius:10px; 
                 width:300px; position:relative; }
.close { position:absolute; top:10px; right:15px; font-size:22px; cursor:pointer; color:#ff1a8c; }
input[type=text], input[type=password], input[type=email] { 
    width:100%; padding:8px; margin:5px 0 10px 0; border-radius:5px; border:1px solid #ffb3d9; 
}
button { padding:8px 12px; border:none; background:#ff4da6; color:#fff; cursor:pointer; border-radius:5px; }
button:hover { background:#e60073; }
.modal-tabs button { background:#ff99cc; color:#fff; border:none; padding:8px 10px; cursor:pointer; 
                     border-radius:5px; margin-right:5px; }
.modal-tabs button:hover { background:#ff4da6; }
</style>
</head>
<body>

<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="window.location='homepage.php'">&times;</span>

    <div class="modal-tabs">
      <button onclick="showTab('login')">Login</button>
      <button onclick="showTab('register')">Register</button>
    </div>

    <div id="loginForm">
      <h3>Login</h3>

      <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <?php if(isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>

      <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <!-- LOGIN BUTTON GOES TO homepage.php -->
        <button type="submit" name="login">Login</button>
      </form>
    </div>

    <div id="registerForm" style="display:none;">
      <h3>Register</h3>
      <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
      </form>
    </div>

  </div>
</div>

<script>
function showTab(tab){
  document.getElementById('loginForm').style.display = (tab=='login') ? 'block':'none';
  document.getElementById('registerForm').style.display = (tab=='register') ? 'block':'none';
}
</script>

</body>
</html>
