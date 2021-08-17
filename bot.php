<?php

/*

سورس ربات نیم بها کننده لینک همراه با وبسرویس
کانال ما : @DimoTM
نویسنده : @DevUltra
منبع بزن.

*/

error_reporting(0);
ob_start('ob_gzhandler');
date_default_timezone_set("Asia/Tehran");

#-----------------------------#

$telegram_ip_ranges = [
['lower' => '149.154.160.0', 'upper' => '149.154.175.255'], 
['lower' => '91.108.4.0',    'upper' => '91.108.7.255'],    
];
$ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
$ok=false;
foreach ($telegram_ip_ranges as $telegram_ip_range){
	if(!$ok){
		$lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
		$upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
		if($ip_dec >= $lower_dec and $ip_dec <= $upper_dec){
			$ok=true;
		}
	}
}
if(!$ok){
	exit(header("location: https://google.com"));
}

#-----------------------------#

$token         = "1723601887:AAFAoNZWQVOtMINcaMG_x7YhGzS0yAKMemk"; # توکن ربات
$api_url       = "https://mmdsadid.ir/bot/Api.php"; # آدرس فایل api.php

#-----------------------------#

$update = json_decode(file_get_contents("php://input"));
if(isset($update->message)){
    $from_id    = $update->message->from->id;
    $chat_id    = $update->message->chat->id;
    $text       = $update->message->text;
    $first_name = $update->message->from->first_name;
    $message_id = $update->message->message_id;
}elseif(isset($update->callback_query)){
    $chat_id    = $update->callback_query->message->chat->id;
    $data       = $update->callback_query->data;
    $query_id   = $update->callback_query->id;
    $message_id = $update->callback_query->message->message_id;
    $from_id    = $update->callback_query->from->id;
    $first_name = $update->callback_query->from->first_name;
}


$update->message->text;
$query = $update->callback_query;
$data = $query->data;
$messageid = $query->message->message_id;
$chatid = $query->message->chat->id;
$fromid = $query->message->from->id;
$callback_query_id = $query->id;
$amiri = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@cinema_great&user_id=".$from_id));
$tch = $amiri->result->status;
#-----------------------------#

define('API_KEY', $token);

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function sendmessage($chat_id,$text,$keyboard = null) {
    bot('sendMessage',[
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "Markdown",
        'disable_web_page_preview' => true,
        'reply_markup' => $keyboard
    ]);
}

function editmessage($chat_id,$message_id,$text,$keyboard = null) {
    bot('editmessagetext',[
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => $text,
        'parse_mode' => "Markdown",
        'disable_web_page_preview' => true,
        'reply_markup' => $keyboard
    ]);
}

function deletemessage($chat_id,$message_id) {
    bot('deletemessage',[
        'chat_id' => $chat_id,
        'message_id' => $message_id,
    ]);
}



function EditMessageText($chat_id,$message_id,$text,$parse_mode,$disable_web_page_preview,$keyboard){
bot('editMessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>$text,
'parse_mode'=>$parse_mode,
'disable_web_page_preview'=>$disable_web_page_preview,
'reply_markup'=>$keyboard
]);
}
function LeaveChat($chat_id){
bot('LeaveChat',[
'chat_id'=>$chat_id
]);
}
function GetChat($chat_id){
bot('GetChat',[
'chat_id'=>$chat_id
]);
}
#-----------------------------#

if(!is_dir("data")){
    
    mkdir("data");

}

if(!is_dir("data/$from_id")){
    
    mkdir("data/$from_id");
    file_put_contents("data/$from_id/step.txt", "none");

}

$step = file_get_contents("data/$from_id/step.txt");

#-----------------------------#

$start_key = json_encode(['keyboard' => [
    [['text' => "نیم بها کردن"],['text' => "کانال ما"]],
], 'resize_keyboard' => true]);

$back_key = json_encode([
  'inline_keyboard'=>[
  [['text'=>"اخبار هالیوود رو دنبال کن 😎",'url'=>'https://t.me/Cinema_Great']],
  ]
  ]);
#-----------------------------#
if($tch != 'member' && $tch != 'creator' && $tch != 'administrator'){
  bot('sendMessage',[
  'chat_id'=>$chat_id,
  'text'=>"جهت استفاده از ربات نیم بها اول در چنل ما عضو شو
 سپس 👀 /start کن
 بعدش میتونی لینکت رایگان نیم بها کنی
 
 ",
  'parse_mode'=>"HTML",
  'reply_markup'=>json_encode([
  'inline_keyboard'=>[
  [['text'=>"🎑عضویت🎑",'url'=>'https://t.me/Cinema_Great']],
  ]
  ])
  ]);
  exit();
  }
  //start
  
if($text == '/start'){
file_put_contents("data/$chat_id/hadi.txt", "none");    
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>'👋سلام به ربات ما خوش آمدی!'
,'reply_to_message_id' =>  $message_id
]);
}
if($text=="/start" or $data == "back" ){
file_put_contents("data/$chat_id/hadi.txt", "none");
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
⬅️ با استفاده از این ربات میتونی لینک دانلودت رو نیم بها کنی!
\n
✅ یکی از گزینه های زیر رو انتخاب کن :
",'parse_mode'=>"HTML",
 'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'نیم بها کردن📥', 'callback_data'=>"sakt"],['text'=>'راهنما❗️','callback_data'=>"delkh"]],[['text'=>'دیگر ربات ها.. ','callback_data'=>"botmove"]],
],
'resize_keyboard'=>true,
])
]);
}

//help

elseif($data == "delkh"){
file_put_contents("data/$from_id/step.txt", "none");
bot('EditMessageText',[
'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=>"به ربات دانلود نیم بها خوش اومدید 🌺\n
👈دانلود نیم بها یعنی اگه فایل شما 2 گیگابایت هست , بعد از دانلود فایل فقط 1 گیگابایت از بسته شما کم میشه!! شما لینک تونو می‌فرستید و بعد لینک نیم بها تحویل میگیرید😄❤️
\n
⚠️ چند نکته مهم 👇🏻
1️⃣ برای دانلود حتما فیلترشکن (vpn) خو را خاموش کنید.\n
2️⃣ لینکی که به شما میدیم برای تمام اوپراتور های ثابت و همراه نیم بها محسوب میشود.\n
3️⃣ لینکی که به ربات ارسال میکنید باید حتما و حتما لینک دانلود مستقیم فایل مورد نظر باشه\n
موفق باشید.\n
Gp Support https://t.me/joinchat/S7ZU4oMHCqZiOTc0
حمایت از ما : https://idpay.ir/cinemagreat
",
'parse_mode'=>"html",  
'disable_web_page_preview' => true, 
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ بازگشت ⬅",'callback_data'=>"back"]],
],
'resize_keyboard'=>true,
])
]);
}

//bot move

elseif($data == "botmove"){
file_put_contents("data/$from_id/step.txt", "none");
bot('EditMessageText',[
'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=>"
🤖لیست ربات های ما ❗️
ربات نیم بها کننده لینک📥
→   @NimDownloader_Bot
→   @NimDownloader_Bot

ربات کوتاه کننده لینک✂️
→   @Shortinglink_Bot
→   @Shortinglink_Bot
 
ربات تبدیل فایل به لینک🤩
→ @Streamfiles_roBot
→ @Streamfiles_roBot
 برای راحتی شما کاربران اهل سینما در دانلود💚
@Cinema_Great
",
'parse_mode'=>"html",  
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ بازگشت ⬅",'callback_data'=>"back"]],
],
'resize_keyboard'=>true,
])
]);
}

elseif($data == "sakt"){
file_put_contents("data/$from_id/step.txt", "nim");
bot('EditMessageText',[
'chat_id'=>$chatid,
'message_id'=>$messageid,
'text'=>"
لطفا لینک خود را ارسال  کنید
",
'parse_mode'=>"html",  
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ بازگشت ⬅",'callback_data'=>"back"]],
],
'resize_keyboard'=>true,
])
]);
}

//nim

elseif($step == "nim"){
    
    if(!preg_match("/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text)){
        
        sendmessage($from_id, "لینک اشتباه است !\n\nمجدد ارسال کنید :");
        
    }else{
        
        sendmessage($from_id, "لطفا کمی صبر کنید...\n\nتا پایان عملیات دستوری برای ربات ارسال نکنید !");
        
        $info = json_decode(file_get_contents($api_url . "?link=" . $text))->download_link;
        
       deletemessage($from_id, $message_id + 1);
        sendmessage($from_id, "لینک شما نیم بها شد !\n\nLink :\n\n$info",$back_key  );
        sendmessage($from_id,"اگر میخواهید دوباره نیم بها کنید /start کنید" );
        file_put_contents("data/$from_id/step.txt", "none");
    
    }
    
}


    
    



/*


سورسبات نیم بها کننده لینک همراه با وبسرویس
کانال ما : @DimoTM
نویسنده : @DevUltra
منبع بزن.


*/
#-----------------------------#

?>
