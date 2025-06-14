<?php

define('API_KEY', '5114433486:AAFmYX2IFj6CE5pkGs8nZru3sff1R7ocPmk');

function bot($method, $datas = []) {
    $url = "https://api.telegram.org/bot" . API_KEY . "/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

$update = json_decode(file_get_contents("php://input"), true);
$message = $update['message'] ?? null;
$callback = $update['callback_query'] ?? null;

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

function get_lang($user_id) {
    global $languages;
    return $languages[$user_id] ?? 'ar';
}

function text($key, $lang) {
    $texts = [
        'start_msg' => [
            'ar' => "مرحباً بك في بوت وصف السيارات 🎮\n\nيمكنك إرسال صورة سيارة من لعبة قراند GTA ثم إدخال التفاصيل ليتم إنشاء وصف تلقائي.\n\nاختر اللغة من الأسفل لبدء الاستخدام.",
            'en' => "Welcome to the Car Description Bot 🎮\n\nSend a GTA car image then enter details to get an automatic description.\n\nChoose your language below to start."
        ],
        'start_name' => ['ar' => "🚘 ارسل اسم السياره أو الشخصية:", 'en' => "🚘 Send the car or character name:"],
        'route' => ['ar' => "🛣️ ارسل نوع الروت (مثل بنز، فورملا):", 'en' => "🛣️ Send the route (e.g., benz, formula):"],
        'color' => ['ar' => "🎨 ارسل لون السيارة:", 'en' => "🎨 Send the car color:"],
        'plate' => ['ar' => "📛 ارسل اللوحة:", 'en' => "📛 Send the plate:"],
        'horn' => ['ar' => "🎺 ارسل اسم البوق:", 'en' => "🎺 Send the horn name:"],
        'targa' => ['ar' => "🚘 هل توجد تارجا؟ (نعم / لا):", 'en' => "🚘 Is there a targa? (yes / no):"],
        'smoke' => ['ar' => "💨 ارسل لون دخان الاطارات:", 'en' => "💨 Send tire smoke color:"],
        'board' => ['ar' => "📍 نوع اللوحة (او اكتب غير معروف):", 'en' => "📍 Plate type (or type 'unknown'):"],
        'glass' => ['ar' => "🪟 نوع القزاز (مثل شفاف أو اخضر):", 'en' => "🪟 Glass type (like CLEAR or green):"],
        'no_car' => ['ar' => "❌ لم يتم العثور على صورة محفوظة، أرسل صورة لبدء الوصف.", 'en' => "❌ No saved car image found. Send a photo to describe it."],
        'lang_set_ar' => ['ar' => "✅ تم تعيين اللغة إلى العربية.", 'en' => "✅ Language set to Arabic."],
        'lang_set_en' => ['ar' => "✅ تم تعيين اللغة إلى الإنجليزية.", 'en' => "✅ Language set to English."],
        'error_msg' => ['ar' => "❌ حدث خطأ، أرسل الصورة مرة أخرى للبدء.", 'en' => "❌ An error occurred, please send the photo again to start."],
        'start_photo' => ['ar' => "🎉 ارسل صورة السيارة للبدء بوصفها.", 'en' => "🎉 Send a car photo to start describing."],
        'help_title' => [
            'ar' => "📚 شرح البوت\nاختر من الأزرار أدناه:",
            'en' => "📚 Bot Explanation\nChoose from the buttons below:"
        ],
        'colors_list' => [
            'ar' => "🎨 الألوان المتاحة:\nأسود، أبيض، أحمر، أخضر، أزرق، أصفر، برتقالي، بنفسجي، زهري، بني، رمادي، فضي، ذهبي، شفاف، أمريكي",
            'en' => "🎨 Available colors:\nBlack, White, Red, Green, Blue, Yellow, Orange, Purple, Pink, Brown, Gray, Silver, Gold, Transparent, American"
        ],
        'how_to_desc' => [
            'ar' => "✍️ كيفية تصميم وصف:\n- أرسل صورة السيارة\n- أدخل اسم السيارة\n- أرسل نوع الروت\n- أدخل اللون\n- أرسل اللوحة\n- أرسل اسم البوق\n- هل توجد تارجا؟\n- أرسل لون دخان الاطارات\n- أدخل نوع اللوحة\n- أدخل نوع القزاز\n\nالبوت سينشئ لك وصفًا تلقائيًا حسب التفاصيل.",
            'en' => "✍️ How to design a description:\n- Send a car photo\n- Enter car name\n- Send route type\n- Enter color\n- Send plate number\n- Send horn name\n- Is there a targa?\n- Send tire smoke color\n- Enter plate type\n- Enter glass type\n\nBot will create an automatic description based on your details."
        ],
        'back_btn' => ['ar' => 'رجوع', 'en' => 'Back'],
        'lang_btn' => ['ar' => 'اللغة', 'en' => 'Language'],
    ];
    return $texts[$key][$lang] ?? $texts[$key]['ar'];
}

function send_language_menu($chat_id, $lang, $msg_id = null) {
    $buttons = [
        [
            ['text' => '🇸🇦 عربي', 'callback_data' => 'lang_ar'],
            ['text' => '🇬🇧 English', 'callback_data' => 'lang_en']
        ],
        [
            ['text' => text('back_btn', $lang), 'callback_data' => 'start_back']
        ]
    ];
    $params = [
        'chat_id' => $chat_id,
        'text' => $lang === 'ar' ? "اختر اللغة:" : "Choose language:",
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ];
    if ($msg_id !== null) {
        $params['message_id'] = $msg_id;
        return bot('editMessageText', $params);
    } else {
        return bot('sendMessage', $params);
    }
}

function send_start($chat_id, $lang) {
    $text = text('start_msg', $lang);
    $buttons = [
        [
            ['text' => text('lang_btn', $lang), 'callback_data' => 'show_lang_menu'],
            ['text' => $lang === 'ar' ? '⭐️ قيّمني' : '⭐️ Rate Me', 'url' => 'https://t.me/wgggk']
        ],
        [
            ['text' => $lang === 'ar' ? 'ابدأ الوصف' : 'Start Description', 'callback_data' => 'start_desc'],
            ['text' => $lang === 'ar' ? 'شرح البوت' : 'Bot Explanation', 'callback_data' => 'bot_help']
        ],
        [
            ['text' => $lang === 'ar' ? 'المطور' : 'Developer', 'url' => 'https://t.me/wgggk']
        ]
    ];
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

function send_help_menu($chat_id, $lang, $msg_id) {
    $text = text('help_title', $lang);
    $buttons = [
        [
            ['text' => $lang === 'ar' ? 'الألوان المتاحة' : 'Available Colors', 'callback_data' => 'help_colors'],
            ['text' => $lang === 'ar' ? 'كيف أصمم وصف' : 'How to Design Description', 'callback_data' => 'help_howto'],
        ],
        [
            ['text' => text('back_btn', $lang), 'callback_data' => 'start_back']
        ]
    ];
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $msg_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
}

function send_help_detail($chat_id, $msg_id, $lang, $type) {
    $text = ($type === 'colors') ? text('colors_list', $lang) : text('how_to_desc', $lang);
    $buttons = [
        [['text' => text('back_btn', $lang), 'callback_data' => 'bot_help']]
    ];
    bot('editMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $msg_id,
        'text' => $text,
        'reply_markup' => json_encode(['inline_keyboard' => $buttons])
    ]);
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

    if ($text === '/lang') {
        send_language_menu($chat_id, $lang);
        exit;
    }

    // باقي خطوات الوصف لاحقًا...
}

if ($callback) {
    $data_cb = $callback['data'];
    $chat_id = $callback['message']['chat']['id'];
    $user_id = $callback['from']['id'];
    $msg_id = $callback['message']['message_id'];
    $lang = get_lang($user_id);

    if ($data_cb === 'show_lang_menu') {
        send_language_menu($chat_id, $lang, $msg_id);
    } elseif ($data_cb === 'lang_ar') {
        $languages[$user_id] = 'ar';
        save_json($lang_file, $languages);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
            'text' => text('lang_set_ar', 'ar'),
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'رجوع', 'callback_data' => 'start_back']]
                ]
            ])
        ]);
    } elseif ($data_cb === 'lang_en') {
        $languages[$user_id] = 'en';
        save_json($lang_file, $languages);
        bot('editMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id,
            'text' => text('lang_set_en', 'en'),
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'Back', 'callback_data' => 'start_back']]
                ]
            ])
        ]);
    } elseif ($data_cb === 'start_back') {
        send_start($chat_id, get_lang($user_id));
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $msg_id]);
    } elseif ($data_cb === 'start_desc') {
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => text('start_photo', $lang)]);
    } elseif ($data_cb === 'bot_help') {
        send_help_menu($chat_id, $lang, $msg_id);
    } elseif ($data_cb === 'help_colors') {
        send_help_detail($chat_id, $msg_id, $lang, 'colors');
    } elseif ($data_cb === 'help_howto') {
        send_help_detail($chat_id, $msg_id, $lang, 'howto');
    }
}
