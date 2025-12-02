<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M.I.A Step & Styles - Premium Footwear</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #fff0f5;
            color: #333;
        }

        header {
            background: #ff69b4;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        nav ul li a i {
            margin-right: 8px;
        }

        nav ul li a:hover {
            color: #ffe6f0;
        }

        .hero {
            background: linear-gradient(135deg, #ffb6c1, #ff69b4);
            color: #fff;
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 25px;
        }

        .featured-products {
            padding: 60px 20px;
            text-align: center;
        }

        .featured-products h2 {
            color: #d63384;
            font-size: 36px;
            margin-bottom: 40px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: #ffe6f0;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(255, 105, 180, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(255, 105, 180, 0.4);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product-card h3 {
            color: #d63384;
            margin-bottom: 8px;
            font-size: 20px;
        }

        .product-card p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }

        .product-card p strong {
            color: #ff1493;
            font-size: 1.1rem;
        }

        .about {
            padding: 60px 20px;
            text-align: center;
            background: #ffd6e0;
        }

        .about h2 {
            font-size: 36px;
            color: #d63384;
            margin-bottom: 25px;
        }

        footer {
            background: #ff69b4;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        footer a {
            color: #fff;
            text-decoration: underline;
        }

        footer a:hover {
            color: #ffe6f0;
        }

        @media(max-width:768px) {
            nav ul {
                flex-direction: column;
                gap: 10px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .product-card img {
                height: 180px;
            }
        }
    </style>

</head>

<body>

    <header>
        <h1>M.I.A Step & Styles</h1>
        <nav>
            <ul>
        
                <li><a href="index.php" id="loginNav"><i class="fa-solid fa-user"></i> Login</a></li>
                
                <li><a href="#about"><i class="fas fa-info-circle"></i> About</a></li>
            </ul>
        </nav>
    </header>

    <section id="home" class="hero">
        <h1><i class="fas fa-home"></i> Step Into Style with M.I.A</h1>
        <p>Discover premium pairs of shoes for every occasion – from casual sneakers to elegant heels.</p>
    </section>

       <section id="product" class="featured-products">
        <h2><i class="fas fa-shoe-prints"></i> Featured Pairs</h2>

        <div class="product-grid">

            <div class="product-card">
                <img src="white sandals.jpg" alt="Classic White Sneakers">
                <h3>Classic White Sneakers</h3>
                <p>Comfortable canvas pair, sizes 6-12. Perfect for casual outings.</p>
                <p><strong>₱2,799</strong></p>
            </div>

            <div class="product-card">
                <img src="RED CLASSY HIGH HEELS.jpg" alt="Elegant Red Heels">
                <h3>Elegant Red Heels</h3>
                <p>Leather pair with 3-inch heel, sizes 5-11. Ideal for parties or work.</p>
                <p><strong>₱4,479</strong></p>
            </div>

            <div class="product-card">
                <img src="Hiking Boots.jpg" alt="Hiking Boots">
                <h3>Hiking Boots</h3>
                <p>Waterproof pair, sizes 7-13. Built for trails and tough terrains.</p>
                <p><strong>₱5,599</strong></p>
            </div>

        </div>
    </section>

    <section id="about" class="about">
      <h2><i class="fas fa-info-circle"></i> About M.I.A Step & Styles</h2>
        <p>At M.I.A Step & Styles, we believe every step should be stylish. Our curated collection of shoes combines
            comfort, quality, and trendsetting designs. From sneakers to boots, find your perfect match today!</p>
    </section>

     <footer>
        <p>&copy; 2025 M.I.A Step & Styles. All rights reserved. |
            Prices in Philippine Peso (₱). <a href="#">Privacy Policy</a>
        </p>
    </footer>

</body>

</html>
