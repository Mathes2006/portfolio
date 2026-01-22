<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        echo "error";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // ================= SMTP SETTINGS =================
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'itsmemathes@gmail.com';     // your Gmail
        $mail->Password   = 'byzpsehbbrcddpwl';          // ✅ NO SPACES
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // ================= EMAIL HEADERS =================
        $mail->setFrom('itsmemathes@gmail.com', 'Portfolio Contact Form');
        $mail->addAddress('itsmemathes@gmail.com'); // receive here
        $mail->addReplyTo($email, $name);           // reply to user

        // ================= EMAIL CONTENT =================
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <h3>New Contact Message</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->send();

        // IMPORTANT: frontend expects exactly this
        echo "success";

    } catch (Exception $e) {
        // Uncomment next line ONLY for debugging
        // echo $mail->ErrorInfo;
        echo "error";
    }
}
?>
