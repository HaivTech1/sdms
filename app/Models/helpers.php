<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\App;

if (!function_exists('getSiteSettings')) {
    function getSiteSettings($column_name)
    {
        $basic = Setting::whereColumn_name($column_name)->first();
        if ($basic)
            return $basic->value;
    }
}

if (!function_exists('translate')) {
    function translate($key, $replace = [])
    {
        if (strpos($key, 'validation.') === 0 || strpos($key, 'passwords.') === 0 || strpos($key, 'pagination.') === 0 || strpos($key, 'order_texts.') === 0) {
            return trans($key, $replace);
        }

        $key = strpos($key, 'messages.') === 0 ? substr($key, 9) : $key;
        $local = default_lang();
        App::setLocale($local);
        try {
            $lang_array = include (base_path('resources/lang/' . $local . '/messages.php'));
            $processed_key = ucfirst(str_replace('_', ' ', remove_invalid_charcaters($key)));

            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
                $result = $processed_key;
            } else {
                $result = trans('messages.' . $key, $replace);
            }
        } catch (\Exception $exception) {
            info($exception);
            $result = trans('messages.' . $key, $replace);
        }

        return $result;
    }
}

if (!function_exists('phoneNumberFormatter')) {
    function phoneNumberFormatter($number)
    {
        $formatted = preg_replace('/\D/', '', $number);

        if (strpos($formatted, '0') === 0) {
            $formatted = substr($formatted, 1);
        }

        if (substr($formatted, -12) !== '234@c.us') {
            $formatted = '234' . $formatted . '@c.us';
        }

        return $formatted;
    }
}

if (!function_exists('inputTypes')) {
    function inputTypes()
    {
        $types = [
            "text",
            "password",
            "email",
            "textarea",
            "select",
            "radio",
            "checkbox",
            "file"
        ];
        return $types;
    }
}

if (!function_exists('ApiResponse')) {
    function ApiResponse($statusCode, $response, $error = null)
    {
        $status = null;

        switch ($statusCode) {
            case 200:
                $status = true;
                break;
            case 403:
                $status = "denied";
                break;
            case 500:
                $status = false;
                break;
            case 400:
                $status = "warning";
                break;
            default:
                $status = "unknown";
                break;
        }

        $responseData = [
            "status" => $status,
            "code" => $statusCode,
            "message" => $response,
        ];

        if ($error !== null) {
            $responseData["error"] = $error;
        }

        return $responseData;
    }
}

if (!function_exists('user_type')) {
    function user_type()
    {
        $types = [
            '1' => 'Super Administrator',
            '2' => 'Administrator',
            '3' => 'User',
        ];

        return $types;
    }
}

if (!function_exists('default_lang')) {
    function default_lang()
    {
        return 'en';
    }
}

if (!function_exists('get_language_name')) {
    function get_language_name($key)
    {
        $languages = array(
            "af" => "Afrikaans",
            "sq" => "Albanian - shqip",
            "am" => "Amharic - አማርኛ",
            "ar" => "Arabic - العربية",
            "an" => "Aragonese - aragonés",
            "hy" => "Armenian - հայերեն",
            "ast" => "Asturian - asturianu",
            "az" => "Azerbaijani - azərbaycan dili",
            "eu" => "Basque - euskara",
            "be" => "Belarusian - беларуская",
            "bn" => "Bengali - বাংলা",
            "bs" => "Bosnian - bosanski",
            "br" => "Breton - brezhoneg",
            "bg" => "Bulgarian - български",
            "ca" => "Catalan - català",
            "ckb" => "Central Kurdish - کوردی (دەستنوسی عەرەبی)",
            "zh" => "Chinese - 中文",
            "zh-HK" => "Chinese (Hong Kong) - 中文（香港）",
            "zh-CN" => "Chinese (Simplified) - 中文（简体）",
            "zh-TW" => "Chinese (Traditional) - 中文（繁體）",
            "co" => "Corsican",
            "hr" => "Croatian - hrvatski",
            "cs" => "Czech - čeština",
            "da" => "Danish - dansk",
            "nl" => "Dutch - Nederlands",
            "en" => "English",
            "en-AU" => "English (Australia)",
            "en-CA" => "English (Canada)",
            "en-IN" => "English (India)",
            "en-NZ" => "English (New Zealand)",
            "en-ZA" => "English (South Africa)",
            "en-GB" => "English (United Kingdom)",
            "en-US" => "English (United States)",
            "eo" => "Esperanto - esperanto",
            "et" => "Estonian - eesti",
            "fo" => "Faroese - føroyskt",
            "fil" => "Filipino",
            "fi" => "Finnish - suomi",
            "fr" => "French - français",
            "fr-CA" => "French (Canada) - français (Canada)",
            "fr-FR" => "French (France) - français (France)",
            "fr-CH" => "French (Switzerland) - français (Suisse)",
            "gl" => "Galician - galego",
            "ka" => "Georgian - ქართული",
            "de" => "German - Deutsch",
            "de-AT" => "German (Austria) - Deutsch (Österreich)",
            "de-DE" => "German (Germany) - Deutsch (Deutschland)",
            "de-LI" => "German (Liechtenstein) - Deutsch (Liechtenstein)",
            "de-CH" => "German (Switzerland) - Deutsch (Schweiz)",
            "el" => "Greek - Ελληνικά",
            "gn" => "Guarani",
            "gu" => "Gujarati - ગુજરાતી",
            "ha" => "Hausa",
            "haw" => "Hawaiian - ʻŌlelo Hawaiʻi",
            "he" => "Hebrew - עברית",
            "hi" => "Hindi - हिन्दी",
            "hu" => "Hungarian - magyar",
            "is" => "Icelandic - íslenska",
            "id" => "Indonesian - Indonesia",
            "ia" => "Interlingua",
            "ga" => "Irish - Gaeilge",
            "it" => "Italian - italiano",
            "it-IT" => "Italian (Italy) - italiano (Italia)",
            "it-CH" => "Italian (Switzerland) - italiano (Svizzera)",
            "ja" => "Japanese - 日本語",
            "kn" => "Kannada - ಕನ್ನಡ",
            "kk" => "Kazakh - қазақ тілі",
            "km" => "Khmer - ខ្មែរ",
            "ko" => "Korean - 한국어",
            "ku" => "Kurdish - Kurdî",
            "ky" => "Kyrgyz - кыргызча",
            "lo" => "Lao - ລາວ",
            "la" => "Latin",
            "lv" => "Latvian - latviešu",
            "ln" => "Lingala - lingála",
            "lt" => "Lithuanian - lietuvių",
            "mk" => "Macedonian - македонски",
            "ms" => "Malay - Bahasa Melayu",
            "ml" => "Malayalam - മലയാളം",
            "mt" => "Maltese - Malti",
            "mr" => "Marathi - मराठी",
            "mn" => "Mongolian - монгол",
            "ne" => "Nepali - नेपाली",
            "no" => "Norwegian - norsk",
            "nb" => "Norwegian Bokmål - norsk bokmål",
            "nn" => "Norwegian Nynorsk - nynorsk",
            "oc" => "Occitan",
            "or" => "Oriya - ଓଡ଼ିଆ",
            "om" => "Oromo - Oromoo",
            "ps" => "Pashto - پښتو",
            "fa" => "Persian - فارسی",
            "pl" => "Polish - polski",
            "pt" => "Portuguese - português",
            "pt-BR" => "Portuguese (Brazil) - português (Brasil)",
            "pt-PT" => "Portuguese (Portugal) - português (Portugal)",
            "pa" => "Punjabi - ਪੰਜਾਬੀ",
            "qu" => "Quechua",
            "ro" => "Romanian - română",
            "mo" => "Romanian (Moldova) - română (Moldova)",
            "rm" => "Romansh - rumantsch",
            "ru" => "Russian - русский",
            "gd" => "Scottish Gaelic",
            "sr" => "Serbian - српски",
            "sh" => "Serbo-Croatian - Srpskohrvatski",
            "sn" => "Shona - chiShona",
            "sd" => "Sindhi",
            "si" => "Sinhala - සිංහල",
            "sk" => "Slovak - slovenčina",
            "sl" => "Slovenian - slovenščina",
            "so" => "Somali - Soomaali",
            "st" => "Southern Sotho",
            "es" => "Spanish - español",
            "es-AR" => "Spanish (Argentina) - español (Argentina)",
            "es-419" => "Spanish (Latin America) - español (Latinoamérica)",
            "es-MX" => "Spanish (Mexico) - español (México)",
            "es-ES" => "Spanish (Spain) - español (España)",
            "es-US" => "Spanish (United States) - español (Estados Unidos)",
            "su" => "Sundanese",
            "sw" => "Swahili - Kiswahili",
            "sv" => "Swedish - svenska",
            "tg" => "Tajik - тоҷикӣ",
            "ta" => "Tamil - தமிழ்",
            "tt" => "Tatar",
            "te" => "Telugu - తెలుగు",
            "th" => "Thai - ไทย",
            "ti" => "Tigrinya - ትግርኛ",
            "to" => "Tongan - lea fakatonga",
            "tr" => "Turkish - Türkçe",
            "tk" => "Turkmen",
            "tw" => "Twi",
            "uk" => "Ukrainian - українська",
            "ur" => "Urdu - اردو",
            "ug" => "Uyghur",
            "uz" => "Uzbek - o‘zbek",
            "vi" => "Vietnamese - Tiếng Việt",
            "wa" => "Walloon - wa",
            "cy" => "Welsh - Cymraeg",
            "fy" => "Western Frisian",
            "xh" => "Xhosa",
            "yi" => "Yiddish",
            "yo" => "Yoruba - Èdè Yorùbá",
            "zu" => "Zulu - isiZulu",
        );
        return array_key_exists($key, $languages) ? $languages[$key] : $key;
    }
}

if (!function_exists('remove_invalid_charcaters')) {
    function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', $str);
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $oldValue = env($envKey);
        if (strpos($str, $envKey) !== false) {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "{$envKey}={$envValue}\n";
        }
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }
}

if (!function_exists('env_update')) {
    function env_update($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents(
                $path,
                str_replace(
                    $key . '=' . env($key),
                    $key . '=' . $value,
                    file_get_contents($path)
                )
            );
        }
    }
}

if (!function_exists('env_key_replace')) {
    function env_key_replace($key_from, $key_to, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents(
                $path,
                str_replace(
                    $key_from . '=' . env($key_from),
                    $key_to . '=' . $value,
                    file_get_contents($path)
                )
            );
        }
    }
}

if (!function_exists('permissionsArray')) {
    function permissionsArray()
    {
        $permissionsArray = [
            "links",
            "pictures",
            "sticker_message",
            "welcome_message",
            "auto_reply",
            "schedule_message",
            "add_participants",
        ];
        return $permissionsArray;
    }
}

if (!function_exists('tokenPermissions')) {
    function tokenPermissions()
    {
        $tokenArray = [
            "get_contacts",
            "create_contact",
            "delete_contact",
            "update_contact",
            "send_single_message",
            "send_group_message",
            "get_sent_message",
            "delete_message",
            "get_schedules",
            "schedule_message",
            "delete_schedule",
            "update_schedule",
        ];
        return $tokenArray;
    }
}

if (!function_exists('command_message')) {
    function command_message()
    {
        $tokenArray = [
            "{business.name}",
            "{business.phone_number}",
            "{business.address}",
            "{business.description}",
            "{add.date}",
            "{add.time}",
        ];
        return $tokenArray;
    }
}

if (!function_exists('checkPrivilegeValue')) {
    function checkPrivilegeValue($type, $value, $subscription)
    {
        $checker = $subscription[$type];

        if ($checker === 'unlimited') {
            $result = true;
        } else {
            $result = false;

            if ($value <= $checker) {
                $result = true;
            } else {
                $result = false;
            }
        }


        return $result;
    }
}

if (!function_exists('input_types')) {
    function input_types()
    {
        $types =
            [
                [
                    "name" => "Text",
                    "id" => "0"
                ],
                [
                    "name" => "Textarea",
                    "id" => "3"
                ],
                [
                    "name" => "File",
                    "id" => "7"
                ],
            ];
        return $types;
    }
}

if (!function_exists('userBalanceAction')) {
    function userBalanceAction($user, $amount, $sign = "-")
    {

        $Cuser = $user ?? auth()->user();
        $balance = $Cuser->wallet_balance;

        if ($sign == "+") {
            $Cuser->wallet_balance = $balance + $amount;
        } else {
            $Cuser->wallet_balance = $balance - $amount;
        }

        $final_balance = $Cuser->wallet_balance;
        $Cuser->save();

        return [
            "success" => true,
            "init_balance" => $balance,
            "final_balance" => $final_balance
        ];
    }
}

if (!function_exists('checkUserWallet')) {
    function checkUserWallet($amount, $user_id = null)
    {
        if ($user_id == null) {
            $user = auth()->user();
        } else {
            $user = User::find($user_id);
        }

        $wallet = (int) $user->wallet_balance;

        if ($wallet < 1)
            return false;

        $check = $wallet >= $amount;

        if ($check == true)
            return true;

        return false;
    }
}
