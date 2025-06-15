<?php
ob_start();
error_reporting(0);
define("API_KEY", '5114433486:AAE3OfitLe5UGde5r7sLQWI2JtHDfmHO_WI');
$botname = bot('getme', ['bot'])->result->username;

function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas); 
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}
$admin = 1965941065 ; // ايديك
$update = json_decode(file_get_contents('php://input'));
$message= $update->message;
$text = $message->text;
$chat_id= $message->chat->id;
$name = $message->from->first_name;
$user = $message->from->username;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$a = strtolower($text);
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$from_id = $message->from->id;
//\\
mkdir("data/$chat_id");
$log = file_get_contents("data/$chat_id/$chat_id.txt");
$EG = file_get_contents("data/$chat_id/eg".$chat_id.".txt");
$c20 = file_get_contents("data/$chat_id/20".$chat_id.".txt");
//\\
$msg = file_get_contents("msg.php");
$forward = file_get_contents("forward.php");
$midea = file_get_contents("midea.php");
$inlin = file_get_contents("inlin.php");
$photoi = file_get_contents("photoi.php");
$upq = file_get_contents("up.php");
$skor = file_get_contents("skor.php");

mkdir("data");

$channel = file_get_contents("link.php");
$link = file_get_contents("link2.php");
$ch = "$channel"; 
$join = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=$ch&user_id=".$from_id);
if($message && (strpos($join,'"status":"left"') or strpos($join,'"Bad Request: USER_ID_INVALID"') or strpos($join,'"status":"kicked"'))!== false){
bot('sendMessage', [
'chat_id'=>$chat_id,
 'text'=>"
»  عليك الاشتراك في قناة تحديثات البوت اولا 📨
»  ليمكنك استخدام البوت  🔊
»  اشترك ثم ارسل { /start }
»  [اضغط هنا للشتراك في القناة]($link)",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
]);return false;}

$uuser = file_get_contents("uuser.php");
$join = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=$uuser&user_id=".$from_id);
if($message && (strpos($join,'"status":"left"') or strpos($join,'"Bad Request: USER_ID_INVALID"') or strpos($join,'"status":"kicked"'))!== false){
bot('sendMessage', [
'chat_id'=>$chat_id,
 'text'=>"
»  عليك الاشتراك في قناة تحديثات البوت اولا 📨
»  ليمكنك استخدام البوت  🔊
»  اشترك ثم ارسل { /start }
»  $uuser",
]);return false;}

$users = explode("\n",file_get_contents("abbas.json"));

if($message){
if(!in_array($from_id,$users)){
file_put_contents("abbas.json",$from_id."\n",FILE_APPEND);}}

$tc = $message->chat->type;
$abbas09 = json_decode(file_get_contents("abbas09.json"),true);
$suodo = $abbas09['sudoarr'];
$al = $abbas09['addmessage'];
$ab = $abbas09['messagee'];
$xll = $al + $ab;
if($message and $from_id !== $admin){
$abbas09['messagee'] = $abbas09['messagee']+1;
file_put_contents("abbas09.json",json_encode($abbas09,32|128|265));
}
if($message and $from_id == $admin){
$abbas09['addmessage'] = $abbas09['addmessage']+1;
file_put_contents("abbas09.json",json_encode($abbas09,32|128|265));
}

$all = count($users)-1;

$adminss = explode("\n",file_get_contents("ad.json"));

$a3bs9 = file_get_contents("data/a3bs9.txt");
$q1 = file_get_contents("data/q1.txt");
$q2 = file_get_contents("q2.txt");
$q3 = file_get_contents("data/q3.txt");
$q4 = file_get_contents("q4.txt");
$q5 = file_get_contents("data/q5.txt");
$aralikan = file_get_contents("q6.txt");

if($message){
if(!in_array($admin,$adminss)){
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"
تم تحديث القائمه /start
",
]);
file_put_contents("ad.json",$admin."\n",FILE_APPEND);
}}

$d = date('D');
$day = explode("\n",file_get_contents($d.".txt"));
$todayuser = count($day);
if($d == "Sat"){
unlink("Fri.txt");
}
if($d == "Sun"){
unlink("Sat.txt");
}
if($d == "Mon"){
unlink("Sun.txt");
}
if($d == "Tue"){
unlink("Mon.txt");
}
if($d == "Wed"){
unlink("The.txt");
}
if($d == "Thu"){
unlink("Wedtxt");
}
if($d == "Fri"){
unlink("Thu.txt");
}
if($message and !in_array($from_id, $day)){ 
file_put_contents($d.".txt",$from_id. "\n",FILE_APPEND);
}

$from_id = $message->from->id;
$name = $message->from->first_name;
$id = $message->from->id;
$user = $message->from->username;
if($user){
$user = "@$user";
}
elseif(!$uaer){
$user = "بلا معرف";
}
if($text =="/start" and !in_array($from_id,$users)){
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"
٭ تم دخول شخص جديد الى البوت الخاص بك 👾
. — — — — — — — — — — .
• معلومات العضو الجديد .
. — — — — — — — — — — .
• الاسم : $name
• المعرف : $user
• الايدي : $id
. — — — — — — — — — — .
• عدد الاعضاء الكلي : $all
",
]);
}

$bot = file_get_contents("bot.txt");

if($text =="/start" and in_array($from_id,$adminss)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*-•
~ اهلا بك في لوحه الأدمن الخاصه بالبوت 🤖

~ يمكنك التحكم في جميع اوامر البوت من هنا 
------------------------------------  
*",
'parse_mode'=>"Markdown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"- قفل البوت ❌.","callback_data"=>"abcd"],["text"=>"- فتح البوت ✅.","callback_data"=>"abcde"]],
[["text"=>"- اعضاء البوت 👥.","callback_data"=>"userd"]],
[["text"=>"- تفعيل التنبيه 🔔.","callback_data"=>"ont"],["text"=>"- تعطيل التنبيه 🔕.","callback_data"=>"oft"]],
[["text"=>"- قسم الاذاعةه 📢.","callback_data"=>"for"]],
[['text' => "- قائمةه الاشتراك 🗣.", 'callback_data' => "channel"],['text' => "- الاشتراك ($skor) .", "callback_data" => "off"]],
[['text' => "- الاحصائيات 📊.", 'callback_data' => "pannel"],['text' => "- قسم المشرفين 👮‍♂️.", 'callback_data' => "lIllabbas"]],
]])
]); 
}

//
if($data =="lIllabbas"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"*
 اهلا بك في قسم مشرفين 👮‍♂️
 يمكنك من خلال هذا القسم
 ☆☆☆☆☆☆☆☆☆☆☆☆☆
 رفع مشرف - تنزيل مشرف - حدف جميع المشرفين
*", 
'parse_mode'=>"Markdown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"- رفع مشرف 👮‍♂️.","callback_data"=>"adl"]],
[["text"=>"- اخر المشرفين👮‍♂️.","callback_data"=>"addmin"]],
[["text"=>"- حدف جميع المشرفين👮‍♂️.","callback_data"=>"delateaddmin"]],
]])
]);   
}

if($data == "adl"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
قم بارسال ايدي العضو 🆔️
 ",
]); 
file_put_contents("data/a3bs9.txt","a3bs9");
}
if($text !="/start" and $a3bs9 == "a3bs9" and !in_array($text,$adminss)){
file_put_contents("data/a3bs9.txt","none");
file_put_contents("ad.json",$text."\n",FILE_APPEND);} 

if($text != "/start" and $a3bs9 == "a3bs9" and !in_array($text,$adminss)){
file_put_contents("data/a3bs9.txt","none");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم رفع العضو ✅", 
]);
bot('sendmessage',[
'chat_id'=>$text,
'text'=>"تم رفعك مشرف في البوت 👮‍♂️", 
]);
}
if($text !="/start" and $a3bs9 == "a3bs9" and in_array($text,$adminss)){
file_put_contents("data/a3bs9.txt","none");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"العضو مشرف بالفعل👮‍♂️", 
]);
}
if($data =="addmin"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"اخر خمس مشرفيه 👥👮‍♂️:
 1 - ".$adminss[count($adminss)-2]."
 2 - ️".$adminss[count($adminss)-3]."
 3 - ️".$adminss[count($adminss)-4]."
 4 - ️".$adminss[count($adminss)-5]."
 5 - ️".$adminss[count($adminss)-6]."
",
'parse_mode'=>"Markdown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"- الصفحه الرئيسيه.","callback_data"=>"bak"]],
]])
]);   
}
if($data =="delateaddmin" and $chat_id2 =="$admin"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
هل انت متاكد من الحذف ❓
",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'لا ❌' ,'callback_data'=>"bak"]],
[['text'=>'نعم ✅' ,'callback_data'=>"yesaarsslan"]],
]])
]);
}
if($data =="yesaarsslan"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
تم حذف المشرفيه👥✅
",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'الصفحه الرئيسيه' ,'callback_data'=>"bak"]],
]])
]);
unlink("ad.json");
}

if($data =="abcde"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"- اهلا بك عزيزي
- تم فتح البوت 
- /start",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'الصفحه الرئيسيه' ,'callback_data'=>"bak"]],
]])
]);
file_put_contents("bot.txt","مفتوح");
} 
if($data =="abcd"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"- اهلا بك عزيزي
- تم قفل البوت
- /start ",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'الصفحه الرئيسيه' ,'callback_data'=>"bak"]],
]])
]); 
file_put_contents("bot.txt","متوقف");
} 

if($text =="/start" and $bot =="متوقف" and $chat_id != "$admin"){
 bot("sendmessage",[
 "chat_id"=>$chat_id,
 "text"=>"تم اغلاق البوت لي اصلاح بعض المشاكل",]);
}

if($data =="userd"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 اهلا بك عزيزي المشرف
 عدد الاعضاء : ( $all )
",
'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'الصفحه الرئيسيه' ,'callback_data'=>"bak"]],
]])
]);
}

if($data == 'ont'){
file_put_contents("ont.php", "on");
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$message_id,
'text'=>"
 مرحبا عزيزي
 تم تفعيل الاشعارات في البوت🔔
➖➖➖➖➖➖➖➖
",
'show_alert'=>true
]);
}
if($data == 'oft'){
file_put_contents("ont.php", "off");
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$message_id,
'text'=>"
 مرحبا عزيزي
⚠ تم تعطيل الاشعارات في البوت
➖➖➖➖➖➖➖➖
",
'show_alert'=>true
]);
}
$ont = file_get_contents("ont.php");
if($ont == "on"){
if($from_id != $admin){
if($message){
bot('ForwardMessage',[
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$message->message_id,
]);
}}}

if($data == "for"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
حسنا عزيزي
قم باختيار ما يناسبك
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"اذاعه صورة 🖼",'callback_data'=>"photoi"]],
[['text' => "اذاعه رسالة ✉", 'callback_data' => "msg"],['text' => "اذاعه توجيه ", 'callback_data' => "forward"]],
[['text' => "اذاعه ميديا ✅", 'callback_data' => "midea"],['text' => "اذاعه انلاين ", 'callback_data' => "inline"]],
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
}
if($data == "msg"){
file_put_contents("msg.php", "on");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 قم بأرسال رسالتك لتحويلها لجميع المشتركين
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"الغاء",'callback_data'=>"bak"]],
]])
]);
}
if($msg == "on"){
if($message){
for($i=0;$i<count($users); $i++){
bot('sendmessage',[
'chat_id'=>$users[$i],
'text'=>"$text",
]);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
حسنا عزيزي
تم عمل اذاعه بنجاح 📢
الى ( $all ) مشترك
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
unlink("msg.php");
}}
if($data == "forward"){
file_put_contents("forward.php", "on");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
حسنا عزيزي
قم بأرسال رسالتك لتحويلها لجميع المشتركين على شكل توجيه
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"الغاء ",'callback_data'=>"bak"]],
]])
]);
}
if($forward == "on"){
if($message){
for($i=0;$i<count($users); $i++){
bot('ForwardMessage',[
'chat_id'=>$users[$i],
'from_chat_id'=>$chat_id,
'message_id'=>$message->message_id,
]);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
حسنا عزيزي
تم عمل اذاعه توجيه بنجاح 📢
الى ( $all ) مشترك
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"bak"]],
]])
]);
unlink("forward.php");
}}
if($data == "midea"){
file_put_contents("midea.php", "on");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
يمكنك استخدام جميع انوع الميديا ماعدى الصوره
(ملصق - فيديو - بصمه - ملف صوتي - ملف - متحركه - جهة اتصال )
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"الغاء",'callback_data'=>"bak"]],
]])
]);
}
$up = json_decode(file_get_contents('php://input'),true);
if(!isset($message->text)){
$types = ['voice','audio','video','photo','contact','document','sticker'];
foreach($up['message'] as $key => $val){
if(in_array($key,$types) and $midea == "on"){
for($i=0;$i<count($users); $i++){
bot('send'.$key,[
'chat_id'=>$users[$i],
'caption'=>$message->caption,
$key=>$val['file_id']]);
unlink("midea.php");
}
}
}}
if($data == "photoi"){
file_put_contents("photoi.php", "on");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
حسنا عزيزي
قم بأرسال الصورة لنشرها لجميع المشتركين
",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"الغاء ",'callback_data'=>"bak"]],
]])
]);
}
if($photoi == "on"){
if($message->photo){
for($i=0;$i<count($users); $i++){
bot('sendphoto',[
'chat_id'=>$users[$i],
'photo'=>$message->photo[0]->file_id,
'caption'=>$message->caption,
]);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"*
حسنا عزيزي
تم نشر الصورة بنجاح 📢
الى ( $all ) مشترك
*",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
unlink("photoi.php");
}}
if($data == "inline"){
file_put_contents("inlin.php", "on");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 قم بتوجيه نص الانلاين لاقوم بنشره للمشتركين",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"الغاء",'callback_data'=>"bak"]],
]])
]);
}
if($inlin == "on"){
if($message->forward_from or $message->forward_from_chat){
for($i=0;$i<count($users); $i++){
bot('forwardmessage',[
'chat_id'=>$users[$i],
'from_chat_id'=>$chat_id,
'message_id'=>$message->message_id,
]);
}
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
 حسنا عزيزي
 تم نشر الانلاين بنجاح
 الى ( $all ) مشترك",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
unlink("inlin.php");
}}

if($data == "channel"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 قم بتحديد الامر لأتمكن من تنفيذه",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"قناة خاصة ",'callback_data'=>"link"]],
[['text'=>"قناة عامة ",'callback_data'=>"user"]],
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
}
if($data == "link"){
file_put_contents("link.php", "on");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 قم برفع البوت مشرف في القناة
 ثم ارسل توجيه من القناة الى هنا",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
}
$channel_id = $message->forward_from_chat->id;
if($channel == "on"){
if($message->forward_from_chat){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
 حسنا عزيزي
 قم الان بأرسال رابط القناة هنا",
]);
file_put_contents("link.php", $channel_id);
file_put_contents("link2.php", "on");
}}
if($link == "on"){
if(preg_match('/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me|(.*)telesco.me|telesco.me(.*)/i',$text)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
 حسنا عزيزي
 تم تفعيل الاشتراك بنجاح",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"اتمام العملية",'callback_data'=>"bak"]],
]])
]);
file_put_contents("link2.php", $text);
file_put_contents("skor.php", "مفعل ✅");
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
 عذرا عزيزي
 قم بأرسال الرابط بصورة صحيحه",
]);
}
}

if($data == "user"){
bot('editmessagetext',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 قم برفع البوت مشرف في القناة
 ثم ارسل يوزر القناة لتفعيل الاشتراك",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
file_put_contents("uuser.php", "on");
}
if($uuser == "on"){
if(preg_match('/^(.*)@|@(.*)|(.*)@(.*)|(.*)#(.*)|#(.*)|(.*)#/',$text)){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
 حسنا عزيزي
 تم تفعيل الاشتراك بنجاح",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"اتمام العملية ⏱",'callback_data'=>"bak"]],
]])
]);
file_put_contents("skor.php", "مفعل ✅");
file_put_contents("uuser.php", $text);
}else{
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
 عذرا عزيزي
 قم بأرسال يوزر بصورة صحيحه",
]);
}
}

if($skor == "معطل ⚠️"){
if($data == 'off'){
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'message_id'=>$message_id,
'text'=>'
 مرحبا عزيزي
 حالة الاشتراك الاجباري معطل
 قم بختيار - قائمةه الاشتراك .وقم بتفعيله
',
 'show_alert'=>true
 ]); 
}}
if($skor == "مفعل ✅"){
if($data == 'off'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>'
 حسنا عزيزي
 حالت الاشتراك الخاص بك مفعل
 هل انت متأكد من رغبتك في تعطيل الاشتراك
',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[
['text'=>'نعم ', 'callback_data'=>'yesde2'],
['text'=>'لا ','callback_data'=>'bak'],
]
]])
]);
}}

if($data == "yesde2"){
unlink("uuser.php");
unlink("link.php");
file_put_contents("skor.php", "معطل ⚠️");
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 تم تعطيل الاشتراك في جميع القنواة
 يمكنك تفعيل الاشتراك لقناتك في مابعد",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>"bak"]],
]])
]);
}

$bloktime = date('h:i:s A');
if($data == "file"){
$path = realpath("abbas.json");
bot('senddocument',[
'chat_id'=>$chat_id2,
'document'=>new CURLFile($path),
'caption'=>"
 نسخة لمشتركينك
 وقت الارسال : ( $bloktime )
 عدد المشتركين : ( $all )
",
]);
}

if($data == "up"){
bot('editmessagetext',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
 حسنا عزيزي
 قم بأرسال ملف الاعضاء الان
 ارسل الملف بأسم : abbas.json",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"رجوع ",'callback_data'=>"bak"]],
]])
]);
file_put_contents("up.php", "on");
}
$rep = $message->document->file_name;
if($upq == "on"){
if($message->document and $message->document->file_name == "abbas.json" ){
$file = "https://api.telegram.org/file/bot".API_KEY."/".bot('getfile',['file_id'=>$message->reply_to_message->document->file_id])->result->file_path;
file_put_contents($message->reply_to_message->document->file_name,file_get_contents($file));
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"* تم رفع الملف  : $rep*",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
]);
unlink("up.php");
}else{
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"* لايمكن رفع الملف  : $rep*",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>"الغاء",'callback_data'=>"bak"]],
]])
]);
}
}

if($data =="pannel"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"*اهلا بك في قسم - الاحصائيات . 📊
. — — — — — — — — — — .
 عدد اعضاء بوتك : $all
 المتفاعلين اليوم  : $todayuser
 عدد الرسائل المرسله : ".$abbas09['addmessage']."
 عدد الرسائل المستلمه : ".$abbas09['messagee']."
 مجموع الرسائل : $xll
. — — — — — — — — — — .
 اخر خمس مشتركين :
▫️ 1- ".$users[count($users)-2]."
▫️ 2- ️".$users[count($users)-3]."
▫️ 3- ️".$users[count($users)-4]."
▫️ 4- ️".$users[count($users)-5]."
▫️ 5- ️".$users[count($users)-6]."
. — — — — — — — — — — .*",'parse_mode'=>"MarkDown",
'reply_markup'=>json_encode([ 
'inline_keyboard'=>[
[['text'=>'الصفحه الرئيسيه' ,'callback_data'=>"bak"]],
]])
]);
}

if($data == "editstart"){
bot('EditMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"
قم بارسال رسالة الاستارت الان
 ",
]); 
file_put_contents("data/q1.txt","q1");
}
if($text != "/start" and $q1 == "q1"){
file_put_contents("data/q1.txt","none");
file_put_contents("q2.txt","$text");
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"تم التعين بنجاح", 
]);
}

if ($data == 'bak'){
$msg = unlink("msg.php");
unlink("forward.php");
unlink("midea.php");
unlink("inlin.php");
unlink("photoi.php");
unlink("up.php");
unlink("up.php");
bot('editmessagetext',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"*-•
~ اهلا بك في لوحه الأدمن الخاصه بالبوت 🤖

~ يمكنك التحكم في جميع اوامر البوت من هنا 
------------------------------------
*",
'parse_mode'=>"Markdown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"- قفل البوت ❌.","callback_data"=>"abcd"],["text"=>"- فتح البوت ✅.","callback_data"=>"abcde"]],
[["text"=>"- اعضاء البوت 👥.","callback_data"=>"userd"]],
[["text"=>"- تفعيل التنبيه 🔔.","callback_data"=>"ont"],["text"=>"- تعطيل التنبيه 🔕.","callback_data"=>"oft"]],
[["text"=>"- قسم الاذاعةه 📢.","callback_data"=>"for"]],
[['text' => "- قائمةه الاشتراك 🗣.", 'callback_data' => "channel"],['text' => "- الاشتراك ($skor) .", "callback_data" => "off"]],
[['text' => "- الاحصائيات 📊.", 'callback_data' => "pannel"],['text' => "- قسم المشرفين 👮‍♂️.", 'callback_data' => "lIllabbas"]],
]])
]);   
}
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}
$message = $update['message'] ?? "";
$message_id = $message['message_id'] ?? "";
$chat_id = $message['chat']['id'] ?? "";
$command = $message['text'] ?? "";
$step_file = "steps.json";
$data_file = "data.json";
$user_images_file = "user_images.json";
$lang_file = "languages.json";

$steps = file_exists($step_file) ? json_decode(file_get_contents($step_file), true) : [];
$data = file_exists($data_file) ? json_decode(file_get_contents($data_file), true) : [];
$user_images = file_exists($user_images_file) ? json_decode(file_get_contents($user_images_file), true) : [];
$languages = file_exists($lang_file) ? json_decode(file_get_contents($lang_file), true) : [];

function save_json($filename, $data) {
    file_put_contents($filename, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

$update = json_decode(file_get_contents("php://input"), true);
$message = $update['message'] ?? null;
$callback = $update['callback_query'] ?? null;

function get_lang($user_id) {
    global $languages;
    return $languages[$user_id] ?? 'ar';
}

function text($key, $lang) {
    $texts = [
        'start_msg' => [
            'ar' => "مرحباً بك في بوت وصف السيارات 🎮\n\nيمكنك إرسال صورة سيارة من لعبة قراند GTA ثم إدخال التفاصيل ليتم إنشاء وصف تلقائي.\n\nاضغط على زر اللغة للاختيار والبدء.",
            'en' => "Welcome to the Car Description Bot 🎮\n\nSend a GTA car image then enter details to get an automatic description.\n\nPress the Language button to choose and start."
        ],
        'start_name' => ['ar' => "🚘 ارسل اسم السياره او الشخصية:", 'en' => "🚘 Send the car or character name:"],
        'route' => ['ar' => "🛣️ ارسل نوع الروت (مثل بنز، فورملا):", 'en' => "🛣️ Send the route (e.g., benz, formula):"],
        'color' => ['ar' => "🎨 ارسل لون السيارة:", 'en' => "🎨 Send the car color:"],
        'plate' => ['ar' => "📛 ارسل اللوحة:", 'en' => "📛 Send the plate:"],
        'horn' => ['ar' => "🎺 ارسل اسم البوق:", 'en' => "🎺 Send the horn name:"],
        'targa' => ['ar' => "🚘 هل توجد تارجا؟ (نعم / لا):", 'en' => "🚘 Is there a targa? (yes / no):"],
        'smoke' => ['ar' => "💨 ارسل لون دخان الاطارات:", 'en' => "💨 Send tire smoke color:"],
        'board' => ['ar' => "📍 نوع اللوحة (او اكتب غير معروف):", 'en' => "📍 Plate type (or type 'unknown'):"],
        'glass' => ['ar' => "🪟 نوع القزاز (مثل شفاف او اخضر):", 'en' => "🪟 Glass type (like CLEAR or green):"],
        'no_car' => ['ar' => "❌ لم يتم العثور على صورة محفوظة، ارسل صورة لبدء الوصف.", 'en' => "❌ No saved car image found. Send a photo to describe it."],
        'lang_set_ar' => ['ar' => "✅ تم تعيين اللغة إلى العربية.", 'en' => "✅ Language set to Arabic."],
        'lang_set_en' => ['ar' => "✅ تم تعيين اللغة إلى الإنجليزية.", 'en' => "✅ Language set to English."],
        'error_msg' => ['ar' => "❌ حدث خطا، ارسل الصورة مرة اخرى للبدء.", 'en' => "❌ An error occurred, please send the photo again to start."],
        'start_photo' => ['ar' => "🎉 ارسل صورة السيارة للبدء بوصفها.", 'en' => "🎉 Send a car photo to start describing."],
        'lang_button' => ['ar' => '🌐 اللغة', 'en' => '🌐 Language'],
        'guide_button' => ['ar' => '📚 شرح البوت', 'en' => '📚 Bot Guide'],
        'colors_button' => ['ar' => '🎨 الالوان المتاحة', 'en' => '🎨 Available Colors'],
        'full_guide_button' => ['ar' => '📖 شرح البوت كامل', 'en' => '📖 Full Bot Guide'],
        'back' => ['ar' => 'رجوع', 'en' => 'Back'],

        // نصوص شرح الالوان
        'colors_text' => [
            'ar' => "🎨 **الالوان المتاحة:**\n\nاسود ⚫\nابيض ⚪\nاحمر 🔴\nاخضر 🟢\nازرق 🔵\nاصفر 💛\nبرتقالي 🟠\nبنفسجي 🟣\nزهري 🌸\nبني 🤎\nرمادي ⚪\nفضي ⚪\nذهبي 🟡\nشفاف 🪟",
            'en' => "🎨 **Available Colors:**\n\nBlack ⚫\nWhite ⚪\nRed 🔴\nGreen 🟢\nBlue 🔵\nYellow 💛\nOrange 🟠\nPurple 🟣\nPink 🌸\nBrown 🤎\nGray ⚪\nSilver ⚪\nGold 🟡\nTransparent 🪟"
        ],

        // نصوص شرح البوت كامل
        'full_guide_text' => [
            'ar' => "📖 **شرح البوت كامل:**\n\nهذا البوت يساعدك على وصف سيارات من لعبة قراند GTA بشكل تلقائي.\n\n1. ارسل صورة سيارة.\n2. اكتب اسم السيارة او الشخصية.\n3. املا باقي التفاصيل خطوة بخطوة.\n4. ستحصل على وصف مفصل مع صورة.\n\nيمكنك تغيير اللغة من زر اللغة.",
            'en' => "📖 **Full Bot Guide:**\n\nThis bot helps you automatically describe cars from GTA game.\n\n1. Send a car photo.\n2. Enter the car or character name.\n3. Fill other details step by step.\n4. You will get a detailed description with the photo.\n\nYou can change the language from the Language button."
        ],
    ];
    return $texts[$key][$lang] ?? $texts[$key]['ar'];
}

function is_empty_name($text) {
    $t = mb_strtolower(trim($text));
    return ($t === '' || $t === 'فاضي' || $t === 'فارغ');
}

function color_to_emoji($text, $lang) {
    $color_map = [
        'black' => '⚫', 'اسود' => '⚫',
        'white' => '⚪', 'ابيض' => '⚪',
        'red' => '🔴', 'احمر' => '🔴',
        'green' => '🟢', 'اخضر' => '🟢',
        'blue' => '🔵', 'ازرق' => '🔵',
        'yellow' => '💛', 'اصفر' => '💛',
        'orange' => '🟠', 'برتقالي' => '🟠',
        'purple' => '🟣', 'بنفسجي' => '🟣',
        'pink' => '🌸', 'زهري' => '🌸',
        'brown' => '🤎', 'بني' => '🤎',
        'gray' => '🪦', 'رمادي' => '🪦',
        'silver' => '⚪', 'فضي' => '⚪',
        'gold' => '🟡', 'ذهبي' => '🟡',
        'transparent' => '🪟', 'شفاف' => '🪟', 'clear' => '🪟',
        'امريكي' => '🔴🔵🤍', 'american' => '🔴🔵🤍',
    ];

    $words = preg_split('/[\s,؛،\.]+/u', mb_strtolower(trim($text)));
    $emojis = [];
    foreach ($words as $w) {
        if (isset($color_map[$w]) && !in_array($color_map[$w], $emojis)) {
            $emojis[] = $color_map[$w];
        }
    }
    return count($emojis) > 0 ? implode('', $emojis) : $text;
}

// دالة خاصة للتارجا تتحول ✅ او ❌ حسب النص
function targa_to_emoji($text) {
    $t = mb_strtolower(trim($text));
    if (in_array($t, ['نعم', 'yes', 'y', '✅'])) {
        return '✅';
    } elseif (in_array($t, ['لا', 'no', 'n', '❌'])) {
        return '❌';
    }
    return $text;
}

function build_caption($car) {
    $caption = "";
    $lang = get_lang($car['user_id'] ?? 0);

    if (!is_empty_name($car['name'] ?? '')) {
        $caption .= "🚘 : {$car['name']}\n\n";
    }

    $routeText = "✔️𝐑𝐮𝐨𝐭𝐞: 𝐦𝐨𝐝 ";
    if (isset($car['route'])) {
        $r = mb_strtolower(trim($car['route']));
        if ($r === 'بنز') $routeText .= "( ⚙️𝐛𝐞𝐧𝐧𝐲,𝐬⚙️ )\n";
        elseif ($r === 'فورملا') $routeText .= "( ⚙️𝐅𝟏⚙️ )\n";
        else $routeText .= "( ⚙️{$car['route']}⚙️ )\n";
    } else {
        $routeText .= "( ⚙️𝐛𝐞𝐧𝐧𝐲,𝐬⚙️ )\n";
    }
    $caption .= $routeText;

    $color_with_emoji = color_to_emoji($car['color'] ?? '', $lang);
    $caption .= "✔️𝐂𝐨𝐥𝐨𝐫𝐬: 𝐦𝐨𝐝 ({$color_with_emoji})\n";
    $caption .= "✔️𝐇𝐨𝐫𝐧: 𝐦𝐨𝐝 ({$car['horn']})\n";

    // هنا التارجا تتحول لرموز
    $caption .= "✔️𝐓𝐚𝐫𝐠𝐚: 𝐦𝐨𝐝 (" . targa_to_emoji($car['targa'] ?? '') . ")\n";

    $smoke_with_emoji = color_to_emoji($car['smoke'] ?? '', $lang);
    $caption .= "✔️𝐓𝐢𝐫𝐞 𝐬𝐦𝐨𝐤𝐞: 𝐦𝐨𝐝 ({$smoke_with_emoji})\n";

    $caption .= "✔️𝐏𝐥𝐚𝐭𝐞: 𝐦𝐨𝐝 ({$car['plate']})\n";
    $caption .= "✔️𝐁𝐨𝐚𝐫𝐝 𝐭𝐲𝐩𝐞: ({$car['board']})\n";
    $caption .= "✔️𝐆𝐥𝐚𝐬𝐬: 𝐦𝐨𝐝 ({$car['glass']})\n";
    $caption .= "✔️𝐅𝐮𝐥𝐥 𝐦𝐨𝐝✅\n✔️𝐓𝐫𝐚𝐝𝐞✅\n✔️𝐏𝐬𝟒✅";

    return $caption;
}

function send_start($chat_id, $lang) {
    $text = text('start_msg', $lang);
    $buttons = [
        [
            ['text' => text('lang_button', $lang), 'callback_data' => 'show_langs'],
            ['text' => text('guide_button', $lang), 'callback_data' => 'show_guide_menu'],
        ],
        [
            ['text' => $lang === 'ar' ? 'ابدا الوصف' : 'Start Description', 'callback_data' => 'start_desc'],
            ['text' => $lang === 'ar' ? 'المطور' : 'Developer', 'url' => 'https://t.me/wgggk']
        ]
    ];
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

function send_lang_menu($chat_id, $msg_id = null, $lang = 'ar') {
    $lang_buttons = [
        [
            ['text' => '🇸🇦 عربي', 'callback_data' => 'lang_ar'],
            ['text' => '🇬🇧 English', 'callback_data' => 'lang_en'],
        ],
        [
            ['text' => text('back', $lang), 'callback_data' => 'start_back']
        ]
    ];

    $params = [
        'chat_id' => $chat_id,
        'text' => text('start_msg', $lang),
        'reply_markup' => json_encode(['inline_keyboard' => $lang_buttons])
    ];

    if ($msg_id !== null) {
        $params['message_id'] = $msg_id;
        bot('editMessageText', $params);
    } else {
        bot('sendMessage', $params);
    }
}

function send_guide_menu($chat_id, $msg_id = null, $lang = 'ar') {
    $guide_buttons = [
        [
            ['text' => text('colors_button', $lang), 'callback_data' => 'show_colors'],
            ['text' => text('full_guide_button', $lang), 'callback_data' => 'show_full_guide'],
        ],
        [
            ['text' => text('back', $lang), 'callback_data' => 'start_back']
        ]
    ];

    $params = [
        'chat_id' => $chat_id,
        'text' => $lang === 'ar' ? "📚 اختر خيار من الاسفل:" : "📚 Choose an option below:",
        'reply_markup' => json_encode(['inline_keyboard' => $guide_buttons])
    ];

    if ($msg_id !== null) {
        $params['message_id'] = $msg_id;
        bot('editMessageText', $params);
    } else {
        bot('sendMessage', $params);
    }
}

if ($message) {
    $chat_id = $message['chat']['id'];
    $user_id = $message['from']['id'];
    $text = $message['text'] ?? '';
    $lang = get_lang($user_id);

    if ($text === '/start') {
        send_start($chat_id, $lang);
        exit;
    }

    if (strtolower($text) === '/lang') {
        send_lang_menu($chat_id, null, $lang);
        exit;
    }
    if (strtolower($text) === '/guide') {
        send_guide_menu($chat_id, null, $lang);
        exit;
    }

    if ($text === '/mycar') {
        if (isset($user_images[$user_id])) {
            $car = $user_images[$user_id];
            $car['user_id'] = $user_id;
            $caption = build_caption($car);
            bot('sendPhoto', [
                'chat_id' => $chat_id,
                'photo' => $car['photo_id'],
                'caption' => $caption . "\n\nby - @fx2ch"
            ]);
        } else {
            bot('sendMessage', ['chat_id' => $chat_id, 'text' => text('no_car', $lang)]);
        }
        exit;
    }

    if (isset($message['photo'])) {
        $file_id = end($message['photo'])['file_id'];
        $steps[$user_id] = 'name';
        $data[$user_id] = ['photo_id' => $file_id];
        save_json($step_file, $steps);
        save_json($data_file, $data);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => text('start_name', $lang)]);
        exit;
    }

    if (isset($steps[$user_id])) {
        $current_step = $steps[$user_id];
        $data[$user_id][$current_step] = $text;

        $order = ['name', 'route', 'color', 'plate', 'horn', 'targa', 'smoke', 'board', 'glass'];
        $current_index = array_search($current_step, $order);

        if ($current_index === false) {
            unset($steps[$user_id], $data[$user_id]);
            save_json($step_file, $steps);
            save_json($data_file, $data);
            bot('sendMessage', ['chat_id' => $chat_id, 'text' => text('error_msg', $lang)]);
            exit;
        }
                $next_index = $current_index + 1;

                if ($next_index < count($order)) {
                    $steps[$user_id] = $order[$next_index];
                    save_json($step_file, $steps);
                    save_json($data_file, $data);

                    // إرسال الرسالة الخاصة بالخطوة التالية
                    bot('sendMessage', [
                        'chat_id' => $chat_id,
                        'text' => text($order[$next_index], $lang)
                    ]);
                } else {
                    // انتهى الإدخال، نحفظ البيانات النهائية ونرسل الوصف
                    $car = $data[$user_id];
                    $car['user_id'] = $user_id;
                    $user_images[$user_id] = $car; // حفظ بيانات السيارة

                    // حذف خطوات الإدخال للمستخدم
                    unset($steps[$user_id]);
                    save_json($step_file, $steps);
                    save_json($data_file, $data);
                    save_json($user_images_file, $user_images);

                    $caption = build_caption($car);

                    bot('sendPhoto', [
                        'chat_id' => $chat_id,
                        'photo' => $car['photo_id'],
                        'caption' => $caption . "\n\nby - @fx2ch"
                    ]);

                    bot('sendMessage', [
                        'chat_id' => $chat_id,
                        'text' => $lang === 'ar' ? "✅ تم إنشاء الوصف بنجاح!" : "✅ Description created successfully!"
                    ]);
                }
                exit;
            }
        }

        if ($callback) {
            $chat_id = $callback['message']['chat']['id'];
            $msg_id = $callback['message']['message_id'];
            $user_id = $callback['from']['id'];
            $data_cb = $callback['data'];
            $lang = get_lang($user_id);

            if ($data_cb === 'show_langs') {
                send_lang_menu($chat_id, $msg_id, $lang);
                exit;
            }

            if ($data_cb === 'start_back') {
                send_start($chat_id, $lang);
                exit;
            }

            if ($data_cb === 'lang_ar') {
                $languages[$user_id] = 'ar';
                save_json($lang_file, $languages);
                bot('answerCallbackQuery', ['callback_query_id' => $callback['id'], 'text' => text('lang_set_ar', 'ar')]);
                send_lang_menu($chat_id, $msg_id, 'ar');
                exit;
            }

            if ($data_cb === 'lang_en') {
                $languages[$user_id] = 'en';
                save_json($lang_file, $languages);
                bot('answerCallbackQuery', ['callback_query_id' => $callback['id'], 'text' => text('lang_set_en', 'en')]);
                send_lang_menu($chat_id, $msg_id, 'en');
                exit;
            }

            if ($data_cb === 'show_guide_menu') {
                send_guide_menu($chat_id, $msg_id, $lang);
                exit;
            }

            if ($data_cb === 'show_colors') {
                bot('editMessageText', [
                    'chat_id' => $chat_id,
                    'message_id' => $msg_id,
                    'text' => text('colors_text', $lang),
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'show_guide_menu']]]
                    ])
                ]);
                exit;
            }

            if ($data_cb === 'show_full_guide') {
                bot('editMessageText', [
                    'chat_id' => $chat_id,
                    'message_id' => $msg_id,
                    'text' => text('full_guide_text', $lang),
                    'parse_mode' => 'Markdown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'show_guide_menu']]]
                    ])
                ]);
                exit;
            }

            if ($data_cb === 'start_desc') {
                bot('editMessageText', [
                    'chat_id' => $chat_id,
                    'message_id' => $msg_id,
                    'text' => text('start_photo', $lang),
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'start_back']]]
                    ])
                ]);
                exit;
            }
        }
