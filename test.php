<?php
session_start();

function generate_string($length = 10) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $str;
}

$captcha_text = generate_string();
$_SESSION['captcha'] = $captcha_text;

$img = imagecreatetruecolor(100, 30);
$bg_color = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 0, 0);
imagefilledrectangle($img, 0, 0, 100, 30, $bg_color);
imagestring($img, 5, 5, 5, $captcha_text, $text_color);
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);








if (isset($_POST['captcha_input']) && isset($_SESSION['captcha'])) {
    if ($_POST['captcha_input'] === $_SESSION['captcha']) {
        // CAPTCHA input is correct, continue with form processing
    } else {
        // CAPTCHA input is incorrect, show an error message
    }
}

