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
        <h1>Create Account</h1>
        <p>Join our Car Work Shop community</p>
        
        <div class="login-container">
            <form action="Backend/handleSignup.php" method="POST">
                <input type="email" id="email" name="email" placeholder="Enter your email..." required>
                <input type="password" id="password" name="password" placeholder="Enter your password..." required>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password..." required>
                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div>
            <p>Already have an account? <a href="index.php">Login</a></p>
        </div>
    </main>

    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        function validatePassword() {
            if (confirmPassword.value === '') {
                confirmPassword.style.borderColor = '#e0e0e0';
                return;
            }
            
            if (password.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#e74c3c';
            } else {
                confirmPassword.style.borderColor = '#27ae60';
            }
        }

        confirmPassword.addEventListener('input', validatePassword);
        password.addEventListener('input', validatePassword);
    </script>
</body>
</html>
