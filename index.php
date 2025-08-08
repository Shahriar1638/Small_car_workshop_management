<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Work Shop</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="Styles/Authstyle.css">
</head>
<body>
    <main>
        <h1>Welcome to Car Work Shop</h1>
        <p>Your trusted partner for all automotive repair and maintenance services</p>
        
        <div class="login-container">
            <form action="./Backend/handleLogin.php" method="POST">
                    <input type="email" id="email" name="email" placeholder="Email..." required>
                    <input type="password" id="password" name="password" placeholder="Password...." required>
                <button type="submit">Login</button>
            </form>
        </div>
        <div>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </main>
</body>
</html>