<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function send_email($sent_to_email, $sent_to_fullname, $subject, $content, $option = array())
{
    global $config;
    $config_email = $config['email'];
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = $config_email['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config_email['smtp_user'];
        $mail->Password = $config_email['smtp_pass'];
        $mail->SMTPSecure = $config_email['smtp_secure'];
        $mail->Port = $config_email['smtp_port'];


        // TCP port to connect to 

        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom($config_email['smtp_user'], $config_email['smtp_fullname']);
        $mail->addAddress($sent_to_email, $sent_to_fullname);
        $mail->addReplyTo($config_email['smtp_user'], $config_email['smtp_fullname']);
        // CC and BCC
        // $mail->addCC('cc1@example.com', 'Elena');
        // $mail->addBCC('bcc1@example.com', 'Alex');
        // Adding more BCC recipients
        // $mail->addBCC('bcc2@example.com', 'Anna');
        // $mail->addBCC('bcc3@example.com', 'Mark');

        // Email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $content; // Example HTML body
        // $mail->AltBody = 'This is the plain text version of the email content';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Email không được gửi: Chi tiết lỗi' . $mail->ErrorInfo;
    }
}
