<?php
session_start();
$adminName = $_SESSION['username'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    background: #ffe6f0;
}

.sidebar {
    width: 280px;
    background: #ff4da6;
    color: white;
    height: 168vh;
    padding: 20px;
    box-sizing: border-box;
    border-radius: 0 20px 20px 0;
    position: relative;
}

.sidebar h2 {
    margin-top: 0;
    font-size: 24px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    margin: 15px 0;
}

.sidebar a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    display: flex;
    align-items: center;
}

.sidebar a::before {
    content: '●';
    margin-right: 10px;
    color: #fff0f5;
}

.account-icon {
    position: absolute;
    bottom: 20px;
    left: 20px;
    font-size: 48px;
    color: white;
}

.account-icon span {
    margin-left: 10px;
    font-size: 18px;
    font-weight: bold;
}

.main {
    flex: 1;
    padding: 20px;
}

.header {
    background: #ff4da6;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.header h1 {
    margin: 0;
    color: white;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.card {
    background: #fff0f5;
    border: 2px solid #ffb3d9;
    padding: 20px;
    border-radius: 15px;
}

.large-card {
    grid-column: span 2;
}

.bar-graph {
    width: 100%;
    height: 200px;
    background: #ffe6f0;
    border-radius: 10px;
    padding: 10px;
}

.bar {
    fill: #ff4da6;
}

.bar:hover {
    fill: #e60073;
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="homepage.php">Homepage</a></li>
    </ul>

    <div class="account-icon">
        <i class="fas fa-user-circle"></i>
        <span><?php echo htmlspecialchars($adminName); ?></span>
    </div>
</div>

<div class="main">
    <div class="header">
        <h1>MIA Admin Dashboard</h1>
    </div>

    <div class="dashboard-grid">
        <div class="card">
            <h3>Total Users</h3>
            <p>1,234</p>
        </div>

        <div class="card">
            <h3>Total Orders</h3>
            <p>890</p>
        </div>

        <div class="card">
            <h3>Active Sessions</h3>
            <p>567</p>
        </div>

        <div class="card large-card">
            <h3>Revenue (Sales Report)</h3>
            <p>12,345</p>

            <svg class="bar-graph" viewBox="0 0 400 200">
                <rect class="bar" x="20" y="120" width="40" height="80"></rect>
                <rect class="bar" x="80" y="100" width="40" height="100"></rect>
                <rect class="bar" x="140" y="80" width="40" height="120"></rect>
                <rect class="bar" x="200" y="60" width="40" height="140"></rect>
                <rect class="bar" x="260" y="40" width="40" height="160"></rect>
                <rect class="bar" x="320" y="20" width="40" height="180"></rect>
            </svg>
        </div>
    </div>
</div>

</body>
</html>
