<?php
session_start();
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Fetch featured items
$featured_query = "SELECT f.*, c.name as category_name 
                   FROM food_items f 
                   JOIN categories c ON f.category_id = c.id 
                   WHERE f.featured = TRUE AND f.status = 'available' 
                   LIMIT 6";
$featured_stmt = $db->prepare($featured_query);
$featured_stmt->execute();
$featured_items = $featured_stmt->fetchAll();

// Fetch categories
$category_query = "SELECT * FROM categories WHERE status = 'active' ORDER BY name";
$category_stmt = $db->prepare($category_query);
$category_stmt->execute();
$categories = $category_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>purat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <i class="fas fa-cube"></i>
                    <span>Purat</span>
                </div>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="products.php">Product</a></li>
                    <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="orders.php">My Orders</a></li>
                        <li class="user-dropdown">
                            <a href="#"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?></a>
                            <div class="dropdown-content">
                                <a href="profile.php">Profile</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login">Login</a></li>
                        <li><a href="register.php" class="btn-register">Register</a></li>
                    <?php endif; ?>
                </ul>

                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="animate-slide-up">
                        Premium App &<br>
                        <span class="gradient-text">Cheap</span>
                    </h1>
                    <p class="animate-slide-up delay-1">
                        WELCOME TO PURAT
                    </p>
                    <div class="hero-buttons animate-slide-up delay-2">
                        <a href="products.php" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i> Shop Now
                        </a>
                        <a href="#featured" class="btn btn-secondary">
                            <i class="fas fa-star"></i> Featured Apps
                        </a>
                    </div>
                    <div class="hero-stats animate-slide-up delay-3">
                        <div class="stat">
                            <h3>50+</h3>
                            <p>Premium Apps</p>
                        </div>
                        <div class="stat">
                            <h3>10K+</h3>
                            <p>Happy Customers</p>
                        </div>
                        <div class="stat">
                            <h3>4.9★</h3>
                            <p>Average Rating</p>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://i.imgur.com/eRQiEU0.png" alt="Premium Software Apps">
                    <div class="floating-card card-1">
                        <i class="fas fa-bolt"></i>
                        <span>Instant Delivery</span>
                    </div>
                    <div class="floating-card card-2">
                        <i class="fas fa-shield-alt"></i>
                        <span>Lifetime Access</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Items Section -->
    <section class="featured" id="featured">
        <div class="container">
            <div class="section-header">
                <h2>Products</h2>
                <p></p>
            </div>
            
            <div class="food-grid">
                <?php foreach ($featured_items as $item): ?>
                <div class="food-card">
                    <div class="food-image">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <span class="badge">Featured</span>
                    </div>
                    <div class="food-content">
                        <span class="category"><?php echo htmlspecialchars($item['category_name']); ?></span>
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                        <div class="food-footer">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <span><?php echo number_format($item['rating'], 1); ?></span>
                            </div>
                            <div class="price">$<?php echo number_format($item['price'], 2); ?></div>
                        </div>
                        <button class="btn-add-cart" onclick="addToCart(<?php echo $item['id']; ?>)">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center" style="margin-top: 40px;">
                <a href="products.php" class="btn btn-primary">View All Software</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Instant Delivery</h3>
                    <p>Get your software license keys delivered instantly after purchase</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3>Lifetime Access</h3>
                    <p>All our software comes with lifetime access and updates</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Customer support available anytime for installation help</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure Payment</h3>
                    <p>100% secure payment processing with encrypted transactions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="logo">
                        <i class="fas fa-cube"></i>
                        <span>SoftMarket</span>
                    </div>
                    <p>Your trusted marketplace for premium software and apps with lifetime access.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Software</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="orders.php">Orders</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    
                    
                </div>
                
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> takev</li>
                        <li><i class="fas fa-phone"></i> +855 71 584 771 3</li>
                        <li><i class="fas fa-envelope"></i> naratoffice@gmail.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Purat. All rights reserved. | Premium App</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>