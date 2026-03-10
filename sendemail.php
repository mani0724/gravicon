<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Load configuration (replace with your actual config method, e.g., .env file)
$smtpHost = getenv('SMTP_HOST') ?: 'smtp.example.com';  // Use env vars for security
$smtpUsername = getenv('SMTP_USERNAME') ?: 'user@example.com';
$smtpPassword = getenv('SMTP_PASSWORD') ?: 'secret';  // Never hardcode in production
$smtpPort = getenv('SMTP_PORT') ?: 465;
$smtpSecure = getenv('SMTP_SECURE') ?: PHPMailer::ENCRYPTION_SMTPS;

// Example recipients (replace with dynamic inputs, e.g., from $_POST)
$toEmail = 'joe@example.net';  // Sanitize inputs if from user
$toName = 'Joe User';
$subject = 'Here is the subject';  // Dynamic
$body = 'This is the HTML message body <b>in bold!</b>';  // Dynamic
$altBody = 'This is the body in plain text for non-HTML mail clients';  // Dynamic

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = $smtpSecure;
    $mail->Port = $smtpPort;

    // Recipients
    $mail->setFrom('from@example.com', 'Mailer');  // Configurable
    $mail->addAddress($toEmail, $toName);
    // Add more as needed: $mail->addReplyTo(...); etc.

    // Attachments (optional, dynamic)
    // $mail->addAttachment('/path/to/file.jpg', 'new.jpg');

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $altBody;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    // Improved error handling: log instead of echo in production
    error_log("Mailer Error: {$mail->ErrorInfo}");
    echo "Message could not be sent. Please try again.";
}