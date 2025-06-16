<?php

define('API_KEY', '5114433486:AAE3OfitLe5UGde5r7sLQWI2JtHDfmHO_WI');

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
