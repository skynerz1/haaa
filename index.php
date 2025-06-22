<?php

// توكن البوت
define('API_KEY', '5114433486:AAFhKB56wAVDsjJGzYiA_kc1EOJe_nGcd1c');

// دالة تنفيذ الأوامر
function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// استقبال التحديثات من Telegram
$update = json_decode(file_get_contents("php://input"), true);

// استخراج البيانات الأساسية
$message = $update["message"];
$text = $message["text"];
$chat_id = $message["chat"]["id"];
$user_id = $message["from"]["id"];
$username = $message["from"]["username"];
$first_name = $message["from"]["first_name"];
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

$caption_style_file = "caption_styles.json";
$caption_styles = file_exists($caption_style_file) ? json_decode(file_get_contents($caption_style_file), true) : [];


$update = json_decode(file_get_contents("php://input"), true);
$message = $update['message'] ?? null;
$callback = $update['callback_query'] ?? null;

function get_lang($user_id) {
    global $languages;
    return $languages[$user_id] ?? 'ar';
}

// ✅ اشتراك إجباري في قناة @JJF_l (يعمل فقط مع الرسائل)
if ($message) {
    $channel = "@JJF_l";
    $check = json_decode(file_get_contents("https://api.telegram.org/bot" . API_KEY . "/getChatMember?chat_id=$channel&user_id=$user_id"), true);
    $status = $check["result"]["status"] ?? null;

    if ($status != "member" && $status != "administrator" && $status != "creator") {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "🚫 لا يمكنك استخدام البوت قبل الاشتراك في القناة التالية:\n📢 $channel\n\nوايضا القروب @fx2ch\n✅ بعد الاشتراك، اضغط /start.",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔔 اشترك الآن", 'url' => "https://t.me/" . ltrim($channel, '@')]],
                    [['text' => "🔔 اشترك الآن", 'url' => "https://t.me/fx2ch"]]

                ]
            ])
        ]);
        exit;
    }
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
        'infow9f' => ['ar' => '📋 الوصوف المتاحة', 'en' => '📋 Available Styles'],
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

function build_caption_v2($car) {
    $caption = "💎 𝗘𝗹𝗶𝘁𝗲 𝗚𝗧𝗔 𝗕𝘂𝗶𝗹𝗱 💎\n";
    $caption .= "🚗 Name: {$car['name']}\n";
    $caption .= "🔧 Route: {$car['route']}\n";
    $color_with_emoji = color_to_emoji($car['color'] ?? '', get_lang($car['user_id'] ?? 0));
    $caption .= "🎨 Color: {$color_with_emoji}\n";
    $caption .= "📛 Plate: {$car['plate']}\n";
    $caption .= "🎺 Horn: {$car['horn']}\n";
    $caption .= "🪟 Glass: {$car['glass']}\n";
    $smoke_with_emoji = color_to_emoji($car['smoke'] ?? '', get_lang($car['user_id'] ?? 0));
    $caption .= "💨 Smoke: {$smoke_with_emoji}\n";
    $caption .= "🛠 Board: {$car['board']}\n";
    $caption .= "🔰 Targa: " . targa_to_emoji($car['targa'] ?? '') . "\n";
    $caption .= "\n🏁 𝗙𝘂𝗹𝗹 𝗺𝗼𝗱 ✔️ | 𝗣𝗦𝟰 ✔️\n";
    $caption .= "CREATIONS ❥(@dfkzbot)";
    return $caption;
}

function build_caption_v3($car) {
    $lang = get_lang($car['user_id'] ?? 0);

    // الألوان مع إيموجيات
    $primary = color_to_emoji($car['color'] ?? '', $lang);
    $secondary = color_to_emoji($car['glass'] ?? '', $lang); // ممكن تغيرها للون ثاني إذا عندك

    // الكفرات
    $wheels = mb_strtolower(trim($car['route'] ?? ''));
    if ($wheels === 'بنز') {
        $wheels_text = "𝐵𝑒𝑛𝑛𝑦’𝑠 𝑊ℎ𝑒𝑒𝑙𝑠";
    } elseif ($wheels === 'فورملا') {
        $wheels_text = "𝐹𝟣 𝑊ℎ𝑒𝑒𝑙𝑠";
    } else {
        $wheels_text = "𝑈𝑛𝑠𝑒𝑙𝑒𝑐𝑡𝑒𝑑 𝑊ℎ𝑒𝑒𝑙 𝑐𝑜𝑙𝑜𝑟";
    }

    // دخان الإطارات
    $smoke = mb_strtolower(trim($car['smoke'] ?? ''));
    if ($smoke === 'امريكي' || $smoke === 'american') {
        $smoke_text = "𝑃𝑎𝑡𝑟𝑖𝑜𝑡 𝑇𝑖𝑟𝑒 𝑆𝑚𝑜𝑘𝑒";
    } elseif ($smoke !== '') {
        $smoke_emoji = color_to_emoji($smoke, $lang);
        $smoke_text = "𝑇𝑖𝑟𝑒 𝑆𝑚𝑜𝑘𝑒 {$smoke_emoji}";
    } else {
        $smoke_text = "𝑇𝑖𝑟𝑒 𝑆𝑚𝑜𝑘𝑒";
    }

    $caption = "𝑁𝑜𝑛 𝐵𝑝—{$primary}\n";
    $caption .= "{$wheels_text}—{$secondary}\n";
    $caption .= "𝑈𝑛𝑠𝑒𝑙𝑒𝑐𝑡𝑒𝑑 𝑅𝑒𝑠𝑝𝑟𝑎𝑦—{$primary}\n";
    $caption .= "𝑈𝑛𝑠𝑒𝑙𝑒𝑐𝑡𝑒𝑑 𝑊ℎ𝑒𝑒𝑙 𝑐𝑜𝑙𝑜𝑟—{$secondary}\n";
    $caption .= "𝑌𝑎𝑛𝑘𝑡𝑜𝑛 𝑃𝑙𝑎𝑡𝑒—{$primary}\n";
    $caption .= "{$smoke_text}—{$secondary}\n";
    $caption .= "𝑁𝑜 𝑇𝑟𝑎𝑑𝑒／𝐹𝑜𝑟 𝑆𝑒𝑙𝑙—{$primary}\n\n";
    $caption .= "𝐶𝑅𝐸𝐴𝑇𝐼𝑂𝑁𝑆 ❥(@dfkzbot)";

    return $caption;
}
function build_caption_v4($car) {
    $primary_color = color_to_emoji($car['color'] ?? '', 'ar'); // اللون الأساسي
    $secondary_color = color_to_emoji($car['glass'] ?? '', 'ar'); // هنا سنعتبر الزجاج هو اللون الثانوي (تقدر تعدله)

    $color_is_modded = stripos($car['color'], 'مهكر') !== false;
    $color_has_pearl = stripos($car['color'], 'لمعة') !== false;

    $color_text = '';
    if ($color_is_modded && $color_has_pearl) {
        $color_text = "𝘔𝘰𝘥𝘥𝘦𝘥 𝘤𝘰𝘭𝘰𝘶𝘳+𝘱𝘦𝘢𝘳𝘭𝘦𝘴𝘤𝘦𝘯𝘵";
    } elseif ($color_is_modded) {
        $color_text = "𝘔𝘰𝘥𝘥𝘦𝘥 𝘤𝘰𝘭𝘰𝘶𝘳";
    } else {
        $color_text = $primary_color . " 𝘤𝘰𝘭𝘰𝘶𝘳";
    }

    $wheels = mb_strtolower($car['route'] ?? '');
    if ($wheels === 'بنز') {
        $wheels_text = "𝘉𝘦𝘯𝘯𝘺’𝘴 𝘸𝘩𝘦𝘦𝘭𝘴";
    } elseif ($wheels === 'فورملا') {
        $wheels_text = "𝘍𝟣 𝘸𝘩𝘦𝘦𝘭𝘴";
    } else {
        $wheels_text = "𝘜𝘯𝘴𝘦𝘭𝘦𝘤𝘵𝘦𝘥 𝘸𝘩𝘦𝘦𝘭 𝘤𝘰𝘭𝘰𝘶𝘳";
    }

    $plate_text = "𝘠𝘢𝘯𝘬𝘵𝘰𝘯 𝘱𝘭𝘢𝘵𝘦𝘴";

    $glass = mb_strtolower($car['glass'] ?? '');
    if ($glass === 'اخضر' || $glass === 'green') {
        $glass_text = "𝘜𝘯𝘴𝘦𝘭𝘦𝘤𝘵𝘦𝘥 𝘸𝘪𝘯𝘥𝘰𝘸𝘴 (𝘨𝘳𝘦𝘦𝘯 𝘵𝘪𝘯𝘵)";
    } else {
        $glass_text = "𝘜𝘯𝘴𝘦𝘭𝘦𝘤𝘵𝘦𝘥 𝘸𝘪𝘯𝘥𝘰𝘸𝘴 (" . ($car['glass'] ?? 'custom') . ")";
    }

    $horn = mb_strtolower($car['horn'] ?? '');
    if ($horn === 'هالوين' || $horn === 'halloween') {
        $horn_text = "𝘜𝘯𝘴𝘦𝘭𝘦𝘤𝘵𝘦𝘥 𝘩𝘰𝘳𝘯 (𝘏𝘢𝘭𝘭𝘰𝘸𝘦𝘦𝘯 𝘩𝘰𝘳𝘯)";
    } else {
        $horn_text = "𝘜𝘯𝘴𝘦𝘭𝘦𝘤𝘵𝘦𝘥 𝘩𝘰𝘳𝘯 (" . ($car['horn'] ?? 'custom') . ")";
    }

    $smoke = mb_strtolower($car['smoke'] ?? '');
    if ($smoke === 'امريكي' || $smoke === 'american') {
        $smoke_text = "𝘗𝘢𝘵𝘳𝘪𝘰𝘵 𝘵𝘪𝘳𝘦 𝘴𝘮𝘰𝘬𝘦";
    } elseif (!empty($smoke)) {
        $emoji = color_to_emoji($smoke, 'ar');
        $smoke_text = $emoji . " 𝘵𝘪𝘳𝘦 𝘴𝘮𝘰𝘬𝘦";
    } else {
        $smoke_text = "𝘜𝘯𝘴𝘦𝘭𝘦𝘤𝘵𝘦𝘥 𝘴𝘮𝘰𝘬𝘦";
    }

    $car_name = $car['name'] ?? 'Unknown';

    return "⚡️ {$car_name} ⚡️\n\n" .
           "▪️{$wheels_text}\n" .
           "▪️{$plate_text}\n" .
           "▪️{$color_text}\n" .
           "▪️{$glass_text}\n" .
           "▪️{$horn_text}\n" .
           "▪️{$smoke_text}\n\n" .
           "𝐶𝑅𝐸𝐴𝑇𝐼𝑂𝑁𝑆 ❥(@dfkzbot)";
}


function send_start($chat_id, $lang) {
    $text = text('start_msg', $lang);
    $buttons = [
        [
            ['text' => text('lang_button', $lang), 'callback_data' => 'show_langs'],
            ['text' => text('guide_button', $lang), 'callback_data' => 'show_guide_menu'],
        ],
        [
        ['text' => $lang === 'ar' ? '🚀 بدء الوصف' : '🚀 Start Description', 'callback_data' => 'show_desc_menu'],


            ['text' => $lang === 'ar' ? 'المطور' : 'Developer', 'url' => 'https://t.me/wgggk']
        ]
    ];
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

function send_desc_menu($chat_id, $msg_id = null, $lang = 'ar') {
    $desc_buttons = [
        [
            ['text' => $lang === 'ar' ? '🚗 وصف سيارات وشخصيات' : '🚗 Cars & Characters', 'callback_data' => 'desc_cars']
        ],
        [
            ['text' => $lang === 'ar' ? '✈️ وصف طيارات' : '✈️ Planes', 'callback_data' => 'desc_planes']
        ],
        [
            ['text' => $lang === 'ar' ? '🏍️ وصف دبابات' : '🏍️ Bikes', 'callback_data' => 'desc_bikes']
        ],
        [
            ['text' => text('back', $lang), 'callback_data' => 'start_back']
        ]
    ];

    $params = [
        'chat_id' => $chat_id,
        'text' => $lang === 'ar' ? "🚀 اختر نوع الوصف:" : "🚀 Choose description type:",
        'reply_markup' => json_encode(['inline_keyboard' => $desc_buttons])
    ];

    if ($msg_id !== null) {
        $params['message_id'] = $msg_id;
        bot('editMessageText', $params);
    } else {
        bot('sendMessage', $params);
    }
}
function send_cars_characters_menu($chat_id, $msg_id = null, $lang = 'ar') {
    $buttons = [
        [
            ['text' => $lang === 'ar' ? '✨ وصف رقم 1' : '✨ Style 1', 'callback_data' => 'start_desc_1'],
            ['text' => $lang === 'ar' ? '💎 وصف رقم 2' : '💎 Style 2', 'callback_data' => 'start_desc_2'],
        ],
        [
            ['text' => $lang === 'ar' ? '🧊 وصف رقم 3' : '🧊 Style 3', 'callback_data' => 'start_desc_3'],
            ['text' => $lang === 'ar' ? '🎭 وصف رقم 4' : '🎭 Style 4', 'callback_data' => 'start_desc_4'],
        ],
        [
            ['text' => text('back', $lang), 'callback_data' => 'show_desc_menu']
        ]
    ];

    $params = [
        'chat_id' => $chat_id,
        'text' => $lang === 'ar' ? 'اختر نمط الوصف:' : 'Choose a caption style:',
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ];

    if ($msg_id !== null) {
        $params['message_id'] = $msg_id;
        bot('editMessageText', $params);
    } else {
        bot('sendMessage', $params);
    }
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
            ['text' => text('infow9f', $lang), 'callback_data' => 'infow9f'],
            
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

                    $style = $caption_styles[$user_id] ?? 1;

                    if ($style === 4) {
                        $caption = build_caption_v4($car); // وصف رقم 4 الجديد
                    } elseif ($style === 3) {
                        $caption = build_caption_v3($car); // وصف رقم 3
                    } elseif ($style === 2) {
                        $caption = build_caption_v2($car); // وصف رقم 2
                    } else {
                        $caption = build_caption($car);    // وصف رقم 1 (الأساسي)
                    }




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

function save_caption_style($user_id, $style) {
    global $caption_styles, $caption_style_file;
    $caption_styles[$user_id] = $style;
    file_put_contents($caption_style_file, json_encode($caption_styles, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}





function infow9f($chat_id, $msg_id, $lang) {
    $buttons = [
        [
            ['text' => '🚗 ' . ($lang === 'ar' ? 'وصف سيارات وشخصيات' : 'Cars & Characters'), 'callback_data' => 'preview_cars']
        ],
        [
            ['text' => '✈️ ' . ($lang === 'ar' ? 'وصف طيارات' : 'Planes'), 'callback_data' => 'preview_planes']
        ],
        [
            ['text' => '🏍️ ' . ($lang === 'ar' ? 'وصف دبابات' : 'Bikes'), 'callback_data' => 'preview_bikes']
        ],
        [
            ['text' => text('back', $lang), 'callback_data' => 'show_guide_menu']
        ]
    ];

    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $msg_id,
        'text' => $lang === 'ar' ? 'اختر نوع الوصف للمعاينة:' : 'Choose a style category to preview:',
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

function preview_cars_menu($chat_id, $msg_id, $lang) {
    $buttons = [
        [
            ['text' => $lang === 'ar' ? '✨ وصف رقم 1' : '✨ Style 1', 'callback_data' => 'preview_desc_1']
        ],
        [
            ['text' => $lang === 'ar' ? '💎 وصف رقم 2' : '💎 Style 2', 'callback_data' => 'preview_desc_2']
        ],
        [
            ['text' => $lang === 'ar' ? '🧊 وصف رقم 3' : '🧊 Style 3', 'callback_data' => 'preview_desc_3']
        ],
        [
            ['text' => $lang === 'ar' ? '🧊 وصف رقم 4' : '🧊 Style 4', 'callback_data' => 'preview_desc_4']
        ],
        [
            ['text' => text('back', $lang), 'callback_data' => 'infow9f']
        ]
    ];

    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $msg_id,
        'text' => $lang === 'ar' ? 'اختر وصف لمعاينته:' : 'Choose a style to preview:',
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

function send_preview_image($chat_id, $msg_id, $img_url, $caption, $lang) {
    bot('deleteMessage', [
        'chat_id' => $chat_id,
        'message_id' => $msg_id
    ]);

    bot('sendPhoto', [
        'chat_id' => $chat_id,
        'photo' => $img_url,
        'caption' => $caption,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [[
                    'text' => text('back', $lang),
                    'callback_data' => 'preview_cars'
                ]]
            ]
        ])
    ]);
}



if ($callback) {
    $chat_id = $callback['message']['chat']['id'];
    $msg_id = $callback['message']['message_id'];
    $user_id = $callback['from']['id'];
    $data_cb = $callback['data'];
    $lang = get_lang($user_id);

if ($data_cb === 'preview_cars') {
    preview_cars_menu($chat_id, $msg_id, $lang);
    exit;
}

if ($data_cb === 'preview_desc_1') {
    send_preview_image($chat_id, $msg_id, 'https://t.me/fx2data/42', '✨ Style 1 Preview', $lang);
    exit;
}
if ($data_cb === 'preview_desc_2') {
    send_preview_image($chat_id, $msg_id, 'https://t.me/fx2data/45', '💎 Style 2 Preview', $lang);
    exit;
}
if ($data_cb === 'preview_desc_3') {
    send_preview_image($chat_id, $msg_id, 'https://t.me/fx2data/46', '🧊 Style 3 Preview', $lang);
    exit;
}
if ($data_cb === 'preview_desc_4') {
    send_preview_image($chat_id, $msg_id, 'https://t.me/fx2data/47', '🧊 Style 4 Preview', $lang);
    exit;
}


    if ($data_cb === 'show_langs') {
        send_lang_menu($chat_id, $msg_id, $lang);
        exit;
    }
    if ($data_cb === 'infow9f') {
    infow9f($chat_id, $msg_id, $lang);
    exit;
}


    if ($data_cb === 'show_desc_menu') {
        send_desc_menu($chat_id, $msg_id, $lang);
        exit;
    }

    if ($data_cb === 'desc_cars') {
        send_cars_characters_menu($chat_id, $msg_id, $lang);
        exit;
    }

    if ($data_cb === 'desc_planes' || $data_cb === 'desc_bikes') {
        $msg = $lang === 'ar' ? 'قريباً 🚧' : 'Coming soon 🚧';
        bot('answerCallbackQuery', [
            'callback_query_id' => $callback['id'],
            'text' => $msg,
            'show_alert' => true
        ]);
        exit;
    }

    
    if ($data_cb === 'start_desc_1') {
        save_caption_style($user_id, 1);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
            'text' => text('start_photo', $lang),
            'reply_markup' => json_encode([
                'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'desc_cars']]]
            ])
        ]);
        exit;
    }

    if ($data_cb === 'start_desc_2') {
        save_caption_style($user_id, 2);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
            'text' => text('start_photo', $lang),
            'reply_markup' => json_encode([
                'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'desc_cars']]]
            ])
        ]);
        exit;
    }

    if ($data_cb === 'start_desc_3') {
        save_caption_style($user_id, 3);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
            'text' => text('start_photo', $lang),
            'reply_markup' => json_encode([
                'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'desc_cars']]]
            ])
        ]);
        exit;
    }

    if ($data_cb === 'start_desc_4') {
        save_caption_style($user_id, 4);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
            'text' => text('start_photo', $lang),
            'reply_markup' => json_encode([
                'inline_keyboard' => [[['text' => text('back', $lang), 'callback_data' => 'desc_cars']]]
            ])
        ]);
        exit;
    }

    



    if ($data_cb === 'start_back') {
        // حذف الرسالة القديمة قبل إرسال رسالة ستارت جديدة
        bot('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id
        ]);

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



