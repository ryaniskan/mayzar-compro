<?php
/**
 * Mail Helper for Mayzar
 * Handles sending emails using SMTP settings from the database.
 */

function send_mail($to, $subject, $message, $from_email = null, $from_name = null)
{
    require_once __DIR__ . '/db.php';
    $settings = db_get_flat('settings');

    $host = $settings['smtp_host'] ?? '';
    $port = $settings['smtp_port'] ?? '587';
    $user = $settings['smtp_user'] ?? '';
    $pass = $settings['smtp_pass'] ?? '';
    $encryption = $settings['smtp_encryption'] ?? 'tls';
    $default_from = $settings['from_email'] ?? '';
    $default_name = $settings['from_name'] ?? 'Mayzar Support';

    $from = $from_email ?? $default_from;
    $name = $from_name ?? $default_name;

    // If SMTP host is not provided, fall back to native mail()
    if (empty($host)) {
        $headers = "From: $name <$from>\r\n";
        $headers .= "Reply-To: $from\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        return mail($to, $subject, $message, $headers);
    }

    // SMTP Implementation using Sockets
    try {
        $socket_host = ($encryption === 'ssl' ? 'ssl://' : '') . $host;
        $socket = fsockopen($socket_host, $port, $errno, $errstr, 30);

        if (!$socket)
            throw new Exception("Could not connect to SMTP host: $errstr ($errno)");

        $getResponse = function ($socket) {
            $response = "";
            while ($line = fgets($socket, 515)) {
                $response .= $line;
                if (substr($line, 3, 1) == " ")
                    break;
            }
            return $response;
        };

        $sendCommand = function ($socket, $cmd) use ($getResponse) {
            fputs($socket, $cmd . "\r\n");
            return $getResponse($socket);
        };

        $getResponse($socket); // Catch initial greeting
        $sendCommand($socket, "EHLO " . $_SERVER['HTTP_HOST']);

        if ($encryption === 'tls') {
            $sendCommand($socket, "STARTTLS");
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception("TLS negotiation failed.");
            }
            $sendCommand($socket, "EHLO " . $_SERVER['HTTP_HOST']);
        }

        if (!empty($user) && !empty($pass)) {
            $sendCommand($socket, "AUTH LOGIN");
            $sendCommand($socket, base64_encode($user));
            $sendCommand($socket, base64_encode($pass));
        }

        $sendCommand($socket, "MAIL FROM: <$from>");
        $sendCommand($socket, "RCPT TO: <$to>");
        $sendCommand($socket, "DATA");

        $data = "To: $to\r\n";
        $data .= "From: $name <$from>\r\n";
        $data .= "Subject: $subject\r\n";
        $data .= "MIME-Version: 1.0\r\n";
        $data .= "Content-Type: text/html; charset=UTF-8\r\n";
        $data .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $data .= $message . "\r\n.\r\n";

        $sendCommand($socket, $data);
        $sendCommand($socket, "QUIT");
        fclose($socket);
        return true;
    } catch (Exception $e) {
        error_log("SMTP Error: " . $e->getMessage());
        return false;
    }
}
