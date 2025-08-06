<?php
// Simple SMTP connectivity test without any library
$server = 'smtp.zoho.com';
$port = 465;
$timeout = 10;

$fp = fsockopen($server, $port, $errno, $errstr, $timeout);
if (!$fp) {
    echo "Could not connect to SMTP server: $errstr ($errno)\n";
    exit;
}
echo "Connected to SMTP server\n";
fputs($fp, "EHLO localhost\r\n");
while ($line = fgets($fp, 512)) {
    echo $line;
    if (strpos($line, '250 ') === 0) break;
}
fclose($fp);
?>