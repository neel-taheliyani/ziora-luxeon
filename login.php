<?php

session_start();

include('include/db_connection.php');

$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_regenerate_id();
                            $_SESSION["logged in"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            header("location: index.php");
                        } else {
                            $password_err = "The password you entered was not correct.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ziora Luxeon</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #1e1e1e;
            color: #f1f1f1;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

header .logo {
    font-size: 2em;
    font-family: 'Lora', serif;
    color: #D4AF37;
    text-transform: uppercase;
    margin-right: 50px;
}

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

.header-scrolled {
    top: 0;
    border-radius: 0 0 50px 50px;
    background: rgba(26, 26, 26, 0.98);
}

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


        .login-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #1e1e1e;
        }

        .login-container {
            width: 50%;
            max-width: 700px;
            background-color: #2c2c2c;
            border-radius: 10px;
            padding: 60px 50px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .login-container h2 {
            font-family: 'Lora', serif;
            color: #D4AF37;
            margin-bottom: 30px;
            font-size: 2.5em;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 1.1em;
            color: #f1f1f1;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            background: #1a1a1a;
            color: #f1f1f1;
        }

        .error {
            color: #ff4d4d;
            font-size: 1em;
            margin-bottom: 15px;
        }

        .btn {
            background-color: #D4AF37;
            color: #1a1a1a;
            padding: 15px 25px;
            font-size: 1.2em;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #f1f1f1;
            color: #1a1a1a;
        }

        footer {
            background-color: #1a1a1a;
            color: #D4AF37;
            text-align: center;
            font-size: 1.5em; 
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .register-link {
            margin-top: 20px;
            font-size: 1em;
            color: #D4AF37;
        }

        .register-link a {
            color: #D4AF37;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
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
            <li><a href="./login.php"class="active">Login</a></li>
            <li><a href="./product.php">Products</a></li>
            <li><a href="./cart.php">Cart</a></li>
            <li><a href="./contact.php">Contact</a></li>
            <li><a href="./about.php" >About Us</a></li>
        </ul>
    </header>

<section class="login-section">
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo $email; ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            <button type="  " class="btn">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="registar.php">Register here</a></p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2025 Ziora Luxeon. All rights reserved.</p>
</footer>

</body>
</html>
