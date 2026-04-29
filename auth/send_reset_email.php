<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If using Composer
require '../vendor/autoload.php';


function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alnoman791@gmail.com'; // Your Gmail
        $mail->Password   = 'nhfl ctaz xkks afxp';   // App Password (not your regular Gmail password)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender and recipient
        $mail->setFrom('alnoman791@gmail.com', 'Fintech Agri');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $resetLink = "http://localhost/agri_fintech/auth/reset_password.php?token=" . urlencode($token);
        $mail->Body    = "Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";

        $mail->send();
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>