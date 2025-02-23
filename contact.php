<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $message = sanitize_input($_POST["message"]);

    if (empty($name)) {
        $nameErr = "Name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
    }
    if (empty($message)) {
        $messageErr = "Message cannot be empty.";
    }

    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@example.com';
            $mail->Password = 'your-email-password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('noreply@zioraluxeon.com', 'Ziora Luxeon');
            $mail->addReplyTo($email, $name);
            $mail->addAddress('admin@example.com');

            $mail->Subject = "New Contact Message from $name";
            $mail->Body = "Name: $name\nEmail: $email\nMessage:\n$message";

            $mail->send();
            echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Message sending failed: " . $mail->ErrorInfo]);
        }
        exit;
    }
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Ziora Luxeon</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #000;
    color: #D8D8D8;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
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

/* MAIN CONTENT */
.main-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 120px 20px 50px;
}

/* CONTACT FORM */
.contact-container {
    max-width: 800px;
    width: 100%;
    background: #2c2c2c;
    border-radius: 15px;
    padding: 40px;
    text-align: center;
    margin: auto;
    box-shadow: 0px 4px 15px rgba(212, 175, 55, 0.5);
}

.contact-container h2 {
    font-size: 2.5em;
    color: #D4AF37;
    margin-bottom: 20px;
}

/* FORM INPUTS */
.form-control {
    display: block;
    width: 90%;
    margin: 15px auto;
    padding: 12px;
    background: #222;
    color: #D4AF37;
    border: 1px solid #D4AF37;
    border-radius: 10px;
    font-size: 1.1em;
    transition: all 0.3s ease;
}

/* Glow effect when focused */
.form-control:focus {
    background: #333;
    outline: none;
    border-color: gold;
    box-shadow: 0px 0px 8px rgba(212, 175, 55, 0.8);
}

/* Error message styling */
.error {
    color: red;
    font-size: 14px;
    font-weight: bold;
    display: block;
    margin-top: 5px;
}

/* SEND MESSAGE BUTTON */
.submit-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 30px;
    background: linear-gradient(135deg, #D4AF37, #b3952f);
    background-size: 200% 200%; /* Ensures smooth gradient transition */
    color: #1a1a1a;
    font-weight: bold;
    border-radius: 25px;
    font-size: 1.1em;
    transition: all 0.3s ease, background-position 0.3s ease; /* Smooth transition */
    cursor: pointer;
    border: none;
    box-shadow: 0px 4px 10px rgba(212, 175, 55, 0.5);
}

.submit-btn:hover {
    background: linear-gradient(135deg, #b3952f, #D4AF37);
    background-position: right center; /* Ensures no flickering */
    transform: scale(1.05);
    box-shadow: 0px 6px 15px rgba(212, 175, 55, 0.8);
}



/* FORM INPUTS (Name, Email, Message) */
input, textarea {
    display: block;
    width: 90%;
    margin: 15px auto;
    padding: 12px;
    background: #222;
    color: #D4AF37;
    border: 1px solid #D4AF37;
    border-radius: 10px;
    font-size: 1.1em;
    transition: all 0.3s ease;
}

/* Glow effect when input is focused */
input:focus, textarea:focus {
    background: #333;
    outline: none;
    border-color: gold;
    box-shadow: 0px 0px 8px rgba(212, 175, 55, 0.8);
}

/* Error message styling */
.error {
    color: red;
    font-size: 14px;
    font-weight: bold;
    display: block;
    margin-top: 5px;
}

/* SEND MESSAGE BUTTON */
.submit-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 30px;
    background: linear-gradient(135deg, #D4AF37, #b3952f);
    color: #1a1a1a;
    font-weight: bold;
    border-radius: 25px;
    font-size: 1.1em;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    box-shadow: 0px 4px 10px rgba(212, 175, 55, 0.5);
}

/* Button Hover Effect */
.submit-btn:hover {
    background: linear-gradient(135deg, #b3952f, #D4AF37);
    transform: scale(1.05);
    box-shadow: 0px 6px 15px rgba(212, 175, 55, 0.8);
}

/* FOOTER */
footer {
    background: #1a1a1a;
    color: #D4AF37;
    font-size: 1.2em;
    text-align: center;
    padding: 20px 0;
    width: 100%;
}

/* ANIMATION */
@keyframes fadeInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        padding: 15px 20px;
        gap: 15px;
    }

    .contact-container {
        padding: 20px;
    }
}


    </style>
</head>

<body>
<header class="navbar">
<div class="logo">
    <a href="index.php">
        <img src="assets/images/logo.png" alt="Ziora Luxeon Logo" class="logo-img">
    </a>
    <span class="logo-text">Ziora Luxeon</span>
</div>

  
    <ul class="navbar-nav">
        <li><a href="./index.php">Home</a></li>
        <li><a href="./login.php">Login</a></li>
        <li><a href="./products.php">Products</a></li>
        <li><a href="./cart.php">Cart</a></li>
        <li><a href="./contact.php" class="active">Contact</a></li>
        <li><a href="./about.php">About Us</a></li>
    </ul>
</header>

<section class="contact-container">
    <h2>Contact Us</h2>
    <form id="contactForm" action="contact.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <label for="name">Name:</label>
        <input type="text" name="name" class="form-control" required>
        <span class="error" id="nameErr"></span>

        <label for="email">Email:</label>
        <input type="email" name="email" class="form-control" required>
        <span class="error" id="emailErr"></span>

        <label for="message">Message:</label>
        <textarea name="message" class="form-control" required></textarea>
        <span class="error" id="messageErr"></span>

        <button type="submit" class="submit-btn">Send Message</button>
    </form>
    <p id="successMessage"></p>
</section>


<footer>
        <p>&copy; 2025 Ziora Luxeon. All rights reserved.</p>
    </footer>
    
<script>
$(document).ready(function(){
    $("#contactForm").submit(function(event){
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "contact.php",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#successMessage").text(response.message).css("color", "green");
                    $("#contactForm")[0].reset();
                } else {
                    $("#successMessage").text(response.message).css("color", "red");
                }
            }
        });
    });

 
});
</script>

</body>
</html>