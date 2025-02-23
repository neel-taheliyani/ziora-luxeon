<?php
include 'include/db_connection.php'; // Make sure this file exists

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate password
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Confirm passwords match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered.";
        } else {
            // Insert new user
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $success = true;
            } else {
                $errors[] = "Failed to register. Try again.";
            }
        }
        $stmt->close();
    }

    // Return JSON response (for AJAX)
    echo json_encode(["success" => $success, "errors" => $errors]);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ziora Luxeon</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <style>
    /* Global Styling */
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #1a1a1a;
    color: #D8D8D8;
    animation: fadeIn 1.2s ease-out;
}
.logo {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between logo and text */
}

.logo img {
    height: 40px;  /* Smaller size */
    width: 40px;
    border-radius: 50%; /* Makes it circular */
    object-fit: cover; /* Ensures proper fit inside circle */
    border: 2px solid #D4AF37; /* Optional: Gold border around logo */
}

.logo-text {
    font-size: 1.2em;
    font-family: 'Lora', serif;
    color: #D4AF37;
    text-transform: uppercase;
}

/* Navbar (Same as Other Pages) */
header {
    background: rgba(42, 42, 42, 0.95);
    padding: 15px 50px;
    display: flex;
    align-items: center;
    position: fixed;
    width: 100%;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    border-radius: 50px;
    max-width: 1200px;
    box-sizing: border-box;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

/* Logo */
header .logo {
    font-size: 2em;
    font-family: 'Lora', serif;
    color: #D4AF37;
    text-transform: uppercase;
    margin-right: 50px;
}

/* Navbar Links */
header .navbar-nav {
    list-style: none;
    display: flex;
    gap: 15px;
    margin: 0;
    padding: 0;
    flex: 1;
    justify-content: center;
}

header .navbar-nav li a {
    font-size: 0.9em;
    color: #D8D8D8;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 25px;
    text-transform: uppercase;
    font-weight: 500;
    transition: all 0.3s ease;
    background: rgba(26, 26, 26, 0.5);
}

header .navbar-nav li a:hover,
header .navbar-nav li a.active {
    background-color: #D4AF37;
    color: #1a1a1a;
    transform: translateY(-2px);
}

/* Navbar Scroll Effect */
.header-scrolled {
    top: 0;
    border-radius: 0 0 50px 50px;
    background: rgba(26, 26, 26, 0.98);
}

/* Responsive Design */
@media (max-width: 768px) {
    header {
        padding: 15px 20px;
        flex-direction: column;
        gap: 15px;
    }

    header .navbar-nav {
        flex-wrap: wrap;
        justify-content: center;
    }
}


/* Register Section */
.register-section {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 80px;
}

/* Registration Form Container */
.register-container {
    width: 100%;
    max-width: 450px;
    background: rgba(40, 40, 40, 0.9);
    border-radius: 12px;
    padding: 40px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(212, 175, 55, 0.15);
    backdrop-filter: blur(10px);
}

/* Heading */
.register-container h2 {
    font-family: 'Lora', serif;
    color: #D4AF37;
    margin-bottom: 20px;
    font-size: 2em;
}

/* Form Group */
.form-group {
    margin-bottom: 20px;
    text-align: left;
}

/* Labels */
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-size: 1em;
    color: #D8D8D8;
}

/* Input Fields */
.form-group input {
    width: 100%;
    padding: 12px;
    font-size: 1em;
    border: 1px solid rgba(212, 175, 55, 0.3);
    border-radius: 8px;
    background: #1a1a1a;
    color: #D8D8D8;
    transition: all 0.3s ease;
}

/* Input Focus Effect */
.form-group input:focus {
    outline: none;
    border-color: #D4AF37;
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
}

/* Button */
.btn {
    background: linear-gradient(90deg, #D4AF37, #E6C456);
    color: #1a1a1a;
    padding: 12px 20px;
    font-size: 1.2em;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.15);
}

.btn:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 18px rgba(212, 175, 55, 0.25);
}

/* Error Message */
.error {
    color: #ff4d4d;
    font-size: 0.9em;
    margin-top: 10px;
}

/* Success Popup */
.popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(30, 30, 30, 0.95);
    color: #D4AF37;
    text-align: center;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 0 20px rgba(212, 175, 55, 0.8);
    width: 90%;
    max-width: 400px;
    backdrop-filter: blur(8px);
}

/* Popup Button */
.popup button {
    background-color: #D4AF37;
    color: #1a1a1a;
    border: none;
    padding: 12px 20px;
    margin-top: 20px;
    cursor: pointer;
    font-size: 1em;
    border-radius: 6px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.popup button:hover {
    background-color: #E6C456;
    transform: scale(1.05);
}

/* Footer */
footer {
    background: #141414;
    color: #D4AF37;
    text-align: center;
    padding: 15px;
    font-size: 1.1em;
    position: fixed;
    bottom: 0;
    width: 100%;
}

/* Fade-in Animation */
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .register-container {
        width: 90%;
        padding: 30px;
    }

    .form-group input {
        padding: 10px;
    }

    .btn {
        font-size: 1.1em;
    }

    h2 {
        font-size: 1.8em;
    }
}

    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="assets/images/logo.png" alt="Ziora Luxeon Logo" class="logo-img">
    </a>
    <span class="logo-text">Ziora Luxeon</span>
</div>
        <ul class="navbar-nav">
            <li><a href="./index.php">Home</a></li>
            <li><a href="./login.php">Login</a></li>
            <li><a href="./product.php">Products</a></li>
            <li><a href="./cart.php">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>

<section class="register-section">
    <div class="register-container">
        <h2>Register</h2>

        <div id="error-message" class="error"></div>

        <form id="registerForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</section>

<!-- Success Popup -->
<div class="popup" id="successPopup">
    <h2>Registration Successful!</h2>
    <p>Welcome to Ziora Luxeon.</p>
    <button onclick="closePopup()">OK</button>
</div>

<script>
document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("", { method: "POST", body: formData })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("successPopup").style.display = "block";
            this.reset();
        } else {
            document.getElementById("error-message").innerHTML = data.errors.map(err => `<p>${err}</p>`).join("");
        }
    });
});

function closePopup() {
    document.getElementById("successPopup").style.display = "none";
    window.location.href = "login.php";
}
</script>

</body>
</html>
