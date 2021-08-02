<?php

//دریافت تمامی ورودی ها
$var = file_get_contents("php://input");
//تبدیل ورودی ها به آرایه
$var = json_decode($var,true);
//دریافت شناسه چت
$chat_id = $var['message']['chat']['id'];
//دریافت پیام ارسال شده توسط کاربر
$text = $var['message']['text'];
//تعریف توکن ربات
$token = "1942161359:AAFyt9qb3TiPzIWTwmvNBx8Z3XkjX0_6Joc";


//این تابع یک پیام ساده ارسال میکند
function sendMessage($chat_id,$text)
{
	global $token;
    $api    = "https://api.telegram.org/bot$token/";
    $method = "sendMessage";
    $params = "?chat_id=$chat_id&text=" . urlencode($text);
  
  	$url = $api . $method . $params;
    $result = file_get_contents($url);
  	return $result;
}
//این تابع یک پیام به همراه کیبورد ساده ارسال میکند
function sendMessageWithKeyboard($chat_id,$text,$reply_markup)
{
	global $token;
    $api    = "https://api.telegram.org/bot$token/";
    $method = "sendMessage";
    $params = "?chat_id=$chat_id&text=" . urlencode($text);
    $params .= "&reply_markup=" . json_encode($reply_markup);
  
  	$url = $api . $method . $params;
    $result = file_get_contents($url);
  	return $result;
}
//تعریف  دکمه های کیبورد
$keyboard_button = array( ['Button 1','Button 2'] );
//تعریف کیبورد
$keyboard = array(
	'keyboard'			=>	$keyboard_button,
	'resize_keyboard'	=>	true,
);
/*
اگر پیام دریافتی از کاربر برابر :
/start
باشد، این خروجی داده خواهد شد
*/
if ( $text == '/start' ) 
{
	$message = "Hi There, Welcome...";
	echo sendMessageWithKeyboard($chat_id,$message,$keyboard);
}
//اگر دکمه شماره 1 فشرده شود
if ( $text == 'Button 1' ) 
{
	$message = "Result From Button 1";
	echo sendMessage($chat_id,$message);
}
//اگر دکمه شماره 2 فشرده شود
if ( $text == 'Button 2' ) 
{
	$message = "Result From Button 2";
	sendMessage($chat_id,$message);
}

?>
