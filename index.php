<?php
session_start();

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "m.i.a";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$msg = '';
$error = '';

if (isset($_POST['register'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address  = $_POST['address'];

  
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name=? OR email=?");
    if (!$stmt) die("Prepare failed: " . $conn->error);

    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Username or email already exists";
    } else {
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO users (customer_name,address,email,user_name,password) VALUES (?,?,?,?,?)");
        if (!$stmt) die("Prepare failed: " . $conn->error);

        $stmt->bind_param("sssss", $name, $address, $email, $username, $password);
        if ($stmt->execute()) {
            $msg = "Registration successful! Please login.";
        } else {
            $error = "Registration failed: " . $stmt->error;
        }
    }
    $stmt->close();
}


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

  
    $stmt = $conn->prepare("SELECT user_id, user_name, password FROM users WHERE user_name=?");
    if (!$stmt) die("Prepare failed: " . $conn->error);

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $user_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $user_name;

            header("Location: homepage.php");
            exit;
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>M.I.A Login</title>
<style>
body { font-family: Arial, sans-serif; margin:0; background:#ffe6f0; }
.modal { display:block; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(255,77,166,0.4); }
.modal-content { background:#fff0f5; margin:10% auto; padding:20px; border-radius:10px; width:300px; position:relative; }
.close { position:absolute; top:10px; right:15px; font-size:22px; cursor:pointer; color:#ff1a8c; }
input[type=text], input[type=password], input[type=email] { width:100%; padding:8px; margin:5px 0 10px 0; border-radius:5px; border:1px solid #ffb3d9; }
button { padding:8px 12px; border:none; background:#ff4da6; color:#fff; cursor:pointer; border-radius:5px; }
button:hover { background:#e60073; }
.modal-tabs button { background:#ff99cc; color:#fff; border:none; padding:8px 10px; cursor:pointer; border-radius:5px; margin-right:5px; }
.modal-tabs button:hover { background:#ff4da6; }
</style>
</head>
<body>
<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="window.location='landingpage.php'">&times;</span>
    <div class="modal-tabs">
      <button onclick="showTab('login')">Login</button>
      <button onclick="showTab('register')">Register</button>
    </div>

    <div id="loginForm">
      <h3>Login</h3>
      <?php if($error) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>
      <?php if($msg) echo "<p style='color:green;'>".htmlspecialchars($msg)."</p>"; ?>
      <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
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
<?php 
if(isset($_POST['register'])) echo "showTab('register');";
elseif(isset($_POST['login'])) echo "showTab('login');";
?>
</script>
</body>
</html>
