<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/mail_helper.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['contact_error'] = "Please fill in all fields.";
        header("Location: contact");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_error'] = "Invalid email address.";
        header("Location: contact");
        exit;
    }

    $settings = db_get_flat('settings');
    $to = $settings['from_email'] ?? 'admin@example.com';
    $subject = "New Contact Message from $name";

    $email_body = "<h2>New Contact Form Submission</h2>";
    $email_body .= "<p><strong>Name:</strong> $name</p>";
    $email_body .= "<p><strong>Email:</strong> $email</p>";
    $email_body .= "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";

    if (send_mail($to, $subject, $email_body, $email, $name)) {
        $_SESSION['contact_success'] = "Your message has been sent successfully!";
    } else {
        $_SESSION['contact_error'] = "Failed to send message. Please try again later.";
    }

    header("Location: contact");
    exit;
}

header("Location: contact");
exit;
