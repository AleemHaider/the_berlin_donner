<?php
  /**
  * PHPMailer based contact form script
  * Replaces the missing "PHP Email Form" library
  */

  // PHPMailer classes use karein
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  // PHPMailer files include karein (Aapko PHPMailer download karke 'assets/vendor/PHPMailer/' folder mein rakhna hoga)
  // Download link: https://github.com/PHPMailer/PHPMailer
  
  $phpmailer_path = '../assets/vendor/PHPMailer/src/';

  if (file_exists($phpmailer_path . 'PHPMailer.php')) {
    require $phpmailer_path . 'Exception.php';
    require $phpmailer_path . 'PHPMailer.php';
    require $phpmailer_path . 'SMTP.php';
  } else {
    die('PHPMailer library not found! Please upload PHPMailer to assets/vendor/PHPMailer/');
  }

  $receiving_email_address = 'hashmatkhanabdulahad@gmail.com';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
      // --- SMTP CONFIGURATION ---
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';         // SMTP server address (e.g., smtp.gmail.com)
      $mail->SMTPAuth   = true;
      $mail->Username   = 'usamavirtualsoftcompany@gmail.com';   // SMTP username
      $mail->Password   = 'iilylrxhzbwucwzv';            // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
      $mail->Port       = 587;                        // TCP port to connect to

      // --- EMAIL SETTINGS ---
      $mail->setFrom($_POST['email'], $_POST['name']);
      $mail->addAddress($receiving_email_address);
      $mail->addReplyTo($_POST['email'], $_POST['name']);

      // Content
      $mail->isHTML(true);
      $mail->Subject = $_POST['subject'];
      
      $message_body = "<h3>New Contact Message</h3>";
      $message_body .= "<p><b>Name:</b> " . htmlspecialchars($_POST['name']) . "</p>";
      $message_body .= "<p><b>Email:</b> " . htmlspecialchars($_POST['email']) . "</p>";
      $message_body .= "<p><b>Subject:</b> " . htmlspecialchars($_POST['subject']) . "</p>";
      $message_body .= "<p><b>Message:</b><br>" . nl2br(htmlspecialchars($_POST['message'])) . "</p>";

      $mail->Body = $message_body;

      $mail->send();
      echo 'OK'; // Frontend JS (validate.js) expects 'OK' on success
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  } else {
    echo "Invalid Request";
  }
?>
