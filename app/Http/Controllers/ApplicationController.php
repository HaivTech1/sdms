<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Application;
use App\Models\TermSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\TestEmailSender;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Term;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('manager.application.index');
    }

    /**
     * Regenerate theme.css from settings and write to public/css/theme.css
     */
    public function regenerateTheme(Request $request)
    {
        // read settings
        $primary = get_settings('primary_color') ?: '#377dff';
        $secondary = get_settings('secondary_color') ?: '#6c757d';
        $appbg = get_settings('app_background_color') ?: '#ffffff';
        $contrast = get_settings('primary_contrast') ?: '#ffffff';

        $css = "/* theme.css - generated from settings */\n";
        $css .= ":root{\n";
        $css .= "  --primary-color: {$primary};\n";
        $css .= "  --secondary-color: {$secondary};\n";
        $css .= "  --app-bg: {$appbg};\n";
        $css .= "  --primary-contrast: {$contrast};\n";
        $css .= "}\n\n";
    $css .= ".btn-primary, .btn-primary:focus, .btn-primary:hover { background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; color: var(--primary-contrast) !important; }\n";
    $css .= ".btn-secondary, .btn-secondary:focus, .btn-secondary:hover { background-color: var(--secondary-color) !important; border-color: var(--secondary-color) !important; color: #fff !important; }\n";
    $css .= "body{ background-color: var(--app-bg) !important; }\n";
    $css .= ".vertical-menu, body[data-sidebar=\"dark\"] .navbar-brand-box { background-color: var(--primary-color) !important; color: var(--primary-contrast) !important; }\n";
    $css .= "#sidebar-menu ul li .badge { background-color: var(--secondary-color) !important; color: #fff !important; }\n";

    // Frontend-specific selectors (welcome page, auth links, cards)
    $css .= ".home-btn .btn-primary, .auth-link .btn-primary, .auth-link .btn-primary.btn-rounded, .card .btn-primary { background-color: var(--primary-color) !important; border-color: var(--primary-color) !important; color: var(--primary-contrast) !important; }\n";
    $css .= "a, a:hover { color: var(--primary-color) !important; }\n";
    $css .= ".card, .wel-hero, .auth-card { background-color: rgba(255,255,255,0.02) !important; border: 1px solid rgba(0,0,0,0.04) !important; }\n";

        try {
            $path = public_path('css/theme.css');
            file_put_contents($path, $css);
            return response()->json(['status' => true, 'message' => 'Theme regenerated'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function mail_config(Request $request)
    {
        Setting::updateOrInsert(
            ['key' => 'mail_config'],
            [
                'value' => json_encode([
                    "status" => $request['status'] ?? 0,
                    "name" => $request['name'],
                    "host" => $request['host'],
                    "driver" => $request['driver'],
                    "port" => $request['port'],
                    "username" => $request['username'],
                    "email_id" => $request['email'],
                    "encryption" => $request['encryption'],
                    "password" => $request['password']
                ]),
                'updated_at' => now()
            ]
        );

        return response()->json(['status' => true, 'message' => 'mail configuration saved successfully!'], 200);
    }

    public function payment_update(Request $request, $name)
    {
        if ($name == 'cash') {
            $payment = Setting::where('key', 'cash')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'cash',
                    'value' => json_encode([
                        'status' => $request['status'],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'cash'])->update([
                    'key' => 'cash',
                    'value' => json_encode([
                        'status' => $request['status'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'digital_payment') {
            $payment = Setting::where('key', 'digital_payment')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'digital_payment',
                    'value' => json_encode([
                        'status' => $request['status'],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'digital_payment'])->update([
                    'key' => 'digital_payment',
                    'value' => json_encode([
                        'status' => $request['status'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'ssl_commerz_payment') {
            $payment = Setting::where('key', 'ssl_commerz_payment')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'ssl_commerz_payment',
                    'value' => json_encode([
                        'status' => 1,
                        'store_id' => '',
                        'store_password' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'ssl_commerz_payment'])->update([
                    'key' => 'ssl_commerz_payment',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'store_id' => $request['store_id'],
                        'store_password' => $request['store_password'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'razor_pay') {
            $payment = Setting::where('key', 'razor_pay')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'razor_pay',
                    'value' => json_encode([
                        'status' => 1,
                        'razor_key' => '',
                        'razor_secret' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'razor_pay'])->update([
                    'key' => 'razor_pay',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'razor_key' => $request['razor_key'],
                        'razor_secret' => $request['razor_secret'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'paypal') {
            $payment = Setting::where('key', 'paypal')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'paypal',
                    'value' => json_encode([
                        'status' => 1,
                        'paypal_client_id' => '',
                        'paypal_secret' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'paypal'])->update([
                    'key' => 'paypal',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'paypal_client_id' => $request['paypal_client_id'],
                        'paypal_secret' => $request['paypal_secret'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'stripe') {
            $payment = Setting::where('key', 'stripe')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'stripe',
                    'value' => json_encode([
                        'status' => 1,
                        'api_key' => '',
                        'published_key' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'stripe'])->update([
                    'key' => 'stripe',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'api_key' => $request['api_key'],
                        'published_key' => $request['published_key'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'senang_pay') {
            $payment = Setting::where('key', 'senang_pay')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([

                    'key' => 'senang_pay',
                    'value' => json_encode([
                        'status' => 1,
                        'secret_key' => '',
                        'published_key' => '',
                        'merchant_id' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'senang_pay'])->update([
                    'key' => 'senang_pay',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'secret_key' => $request['secret_key'],
                        'published_key' => $request['publish_key'],
                        'merchant_id' => $request['merchant_id'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'paystack') {
            $payment = Setting::where('key', 'paystack')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'paystack',
                    'value' => json_encode([
                        'status' => 1,
                        'publicKey' => '',
                        'secretKey' => '',
                        'paymentUrl' => '',
                        'merchantEmail' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'paystack'])->update([
                    'key' => 'paystack',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'publicKey' => $request['publicKey'],
                        'secretKey' => $request['secretKey'],
                        'paymentUrl' => $request['paymentUrl'],
                        'merchantEmail' => $request['merchantEmail'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'flutterwave') {
            $payment = Setting::where('key', 'flutterwave')->first();
            if (isset($payment) == false) {
                DB::table('settings')->insert([
                    'key' => 'flutterwave',
                    'value' => json_encode([
                        'status' => 1,
                        'public_key' => '',
                        'secret_key' => '',
                        'hash' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->where(['key' => 'flutterwave'])->update([
                    'key' => 'flutterwave',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'public_key' => $request['public_key'],
                        'secret_key' => $request['secret_key'],
                        'hash' => $request['hash'],
                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'mercadopago') {
            $payment = Setting::updateOrInsert(
                ['key' => 'mercadopago'],
                [
                    'value' => json_encode([
                        'status' => $request['status'],
                        'public_key' => $request['public_key'],
                        'access_token' => $request['access_token'],
                    ]),
                    'updated_at' => now()
                ]
            );
        } elseif ($name == 'paymob_accept') {
            DB::table('settings')->updateOrInsert(['key' => 'paymob_accept'], [
                'value' => json_encode([
                    'status' => $request['status'],
                    'api_key' => $request['api_key'],
                    'iframe_id' => $request['iframe_id'],
                    'integration_id' => $request['integration_id'],
                    'hmac' => $request['hmac'],
                ]),
                'updated_at' => now()
            ]);
        } elseif ($name == 'liqpay') {
            DB::table('settings')->updateOrInsert(['key' => 'liqpay'], [
                'value' => json_encode([
                    'status' => $request['status'],
                    'public_key' => $request['public_key'],
                    'private_key' => $request['private_key']
                ]),
                'updated_at' => now()
            ]);
        } elseif ($name == 'paytm') {
            DB::table('settings')->updateOrInsert(['key' => 'paytm'], [
                'value' => json_encode([
                    'status' => $request['status'],
                    'paytm_merchant_key' => $request['paytm_merchant_key'],
                    'paytm_merchant_mid' => $request['paytm_merchant_mid'],
                    'paytm_merchant_website' => $request['paytm_merchant_website'],
                    'paytm_refund_url' => $request['paytm_refund_url'],
                ]),
                'updated_at' => now()
            ]);
        } elseif ($name == 'bkash') {
            DB::table('settings')->updateOrInsert(['key' => 'bkash'], [
                'value' => json_encode([
                    'status' => $request['status'],
                    'api_key' => $request['api_key'],
                    'api_secret' => $request['api_secret'],
                    'username' => $request['username'],
                    'password' => $request['password'],
                ]),
                'updated_at' => now()
            ]);
        } elseif ($name == 'paytabs') {
            DB::table('settings')->updateOrInsert(['key' => 'paytabs'], [
                'value' => json_encode([
                    'status' => $request['status'],
                    'profile_id' => $request['profile_id'],
                    'server_key' => $request['server_key'],
                    'base_url' => $request['base_url']
                ]),
                'updated_at' => now()
            ]);
        }

        $notification = array(
            [
                'messege' => 'Payment updated successfully!',
                'alert-type' => 'success',
                'button' => 'Okay!',
                'title' => 'Successful'
            ]
        );

        return redirect()->back()->with($notification);
    }

    //Send Mail
    public function send_mail(Request $request)
    {
        $response_flag = 0;
        try {
            Mail::to($request->email)->send(new TestEmailSender());
            $response_flag = 1;
        } catch (\Exception $exception) {
            info($exception);
            $response_flag = 2;
        }

        return response()->json(['status' => true, 'message' => 'Mail sent successfully!'], 200);
    }

    public function maintenance_mode()
    {
        $maintenance_mode = Setting::where('key', 'maintenance_mode')->first();
        if (isset($maintenance_mode) == false) {
            DB::table('settings')->insert([
                'key' => 'maintenance_mode',
                'value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('settings')->where(['key' => 'maintenance_mode'])->update([
                'key' => 'maintenance_mode',
                'value' => $maintenance_mode->value == 1 ? 0 : 1,
                'updated_at' => now(),
            ]);
        }

        if (isset($maintenance_mode) && $maintenance_mode->value) {
            Artisan::call('up');
            return response()->json(['message' => 'Maintenance is off.'], 200);
        }

        Artisan::call('down');
        return response()->json(['message' => 'Maintenance is on.'], 200);
    }

    public function update_notification(Request $request)
    {
        $field = key($request->all());
        $value = $request->input($field);

        $notification = Setting::where('key', '' . $field)->first();
        if (isset($notification) == false) {
            DB::table('settings')->insert([
                'key' => '' . $field,
                'value' => $value,
            ]);
        } else {
            DB::table('settings')->where(['key' => '' . $field])->update([
                'key' => '' . $field,
                'value' => $value,
            ]);
        }

        // Separate the field name and capitalize the first word
        $fieldParts = explode('_', $field);
        $fieldName = Str::ucfirst($fieldParts[0]) . ' ' . Str::ucfirst($fieldParts[1]);

        if (isset($notification) && $notification->value) {
            return response()->json(['message' => $fieldName . ' is off.'], 200);
        }
        return response()->json(['message' => $fieldName . ' is on.'], 200);
    }

    public function format(Request $request)
    {
        try {
            foreach ($request->addmore as $data) {
                $setting = Setting::where('key', $data['key'])->first();
                if ($setting) {
                    $setting->value = json_encode($this->parseData($data['value']));
                    $setting->save();
                } else {
                    Setting::create([
                        'key' => $data['key'],
                        'value' => json_encode($this->parseData($data['value']))
                    ]);
                }
            }
            return response()->json(['status' => true, 'message' => 'Setting saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function color(Request $request)
    {
        try {
            foreach ($request->addmore as $data) {
                $setting = Setting::where('key', $data['key'])->first();
                if ($setting) {
                    $setting->value = json_encode($this->parseColor($data['value']));
                    $setting->save();
                } else {
                    Setting::create([
                        'key' => $data['key'],
                        'value' => json_encode($this->parseColor($data['value']))
                    ]);
                }
            }
            return response()->json(['status' => true, 'message' => 'Setting saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function grade(Request $request)
    {
        try {
            foreach ($request->addmore as $data) {
                $setting = Setting::where('key', $data['key'])->first();
                if ($setting) {
                    $setting->value = json_encode($this->parseGrade($data['value']));
                    $setting->save();
                } else {
                    Setting::create([
                        'key' => $data['key'],
                        'value' => json_encode($this->parseGrade($data['value']))
                    ]);
                }
            }
            return response()->json(['status' => true, 'message' => 'Setting saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function parseData($data)
    {
        $parsed = [];
        $items = explode(',', $data);
        foreach ($items as $item) {
            $values = explode(':', $item);
            $parsed[$values[0]] = ['full_name' => $values[1], 'mark' => $values[2]];
        }
        return $parsed;
    }

    private function parseColor($data)
    {
        $parsed = [];
        $items = explode(',', $data);
        foreach ($items as $item) {
            $values = explode(':', $item);
            $parsed[$values[0]] = ['from' => $values[1], 'color' => $values[2]];
        }
        return $parsed;
    }

    private function parseGrade($data)
    {
        $parsed = [];
        $items = explode(',', $data);
        foreach ($items as $item) {
            $values = explode(':', $item);
            $parsed[$values[0]] = ['from' => $values[1], 'text' => $values[2]];
        }
        return $parsed;
    }

    private function parseDomain($data)
    {
        $parsed = [];
        $items = explode(',', $data);
        foreach ($items as $item) {
            $parsed[] = $item;
        }
        return $parsed;
    }

    public function domain(Request $request)
    {
        try {
            foreach ($request->addmore as $data) {
                $setting = Setting::where('key', $data['key'])->first();
                if ($setting) {
                    $setting->value = json_encode($this->parseDomain($data['value']));
                    $setting->save();
                } else {
                    Setting::create([
                        'key' => $data['key'],
                        'value' => json_encode($this->parseDomain($data['value']))
                    ]);
                }
            }
            return response()->json(['status' => true, 'message' => 'Setting saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getTermSetting()
    {
        try {
            $termSettings = TermSetting::with(['term', 'period'])->orderBy('period_id', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $termSettings
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function getSingleTermSetting($id)
    {
        try {
            $termSetting = TermSetting::find($id);
            if (!$termSetting) {
            return response()->json(['status' => false, 'message' => 'Term setting not found.'], 404);
            }
            return response()->json(['status' => true, 'data' => $termSetting], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching the term setting.'
            ], 500);
        }
    }

    public function termSetting(Request $request)
    {
        try {
            // $data = $request->all();
            // $validatedData = Validator::make($data, [
            //     'resumption_date' => 'required',
            //     'vacation_date' => 'required',
            //     'no_school_opened' => 'required',
            //     'next_term_resumption' => 'required',
            // ]);

            // if ($validatedData->fails()) {
            //     $error = "";
            //     foreach ($validatedData->errors()->all() as $key => $value) {
            //         $error .= $value;
            //     }
            //     return response()->json(['status' => false, 'message' => $error], 500);
            // }

            $check = TermSetting::where('term_id', $request->term_id)->where('period_id', $request->period_id)->first();

            if (!$check) {
                $setting = new TermSetting([
                    'term_id' => $request->term_id,
                    'period_id' => $request->period_id,
                    'resumption_date' => $request->resumption_date,
                    'vacation_date' => $request->vacation_date,
                    'no_school_opened' => $request->no_school_opened,
                    'next_term_resumption' => $request->next_term_resumption,
                    'class_count' => $request->class_count,
                ]);
                $setting->save();

                return response()->json(['status' => true, 'message' => "Setting created successfully"], 201);
            } else {
                $data = [];

                if (isset($request->resumption_date)) {
                    $data['resumption_date'] = $request->resumption_date;
                }

                if (isset($request->vacation_date)) {
                    $data['vacation_date'] = $request->vacation_date;
                }

                if (isset($request->no_school_opened)) {
                    $data['no_school_opened'] = $request->no_school_opened;
                }

                if (isset($request->next_term_resumption)) {
                    $data['next_term_resumption'] = $request->next_term_resumption;
                }

                if (isset($request->class_count)) {
                    $data['class_count'] = $request->class_count;
                }

                $check->update($data);

                return response()->json(['status' => true, 'message' => "Setting updated successfully"], 200);
            }

        } catch (\Exception $e) {
            info('Term setting error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => "Sorry, There was an error creating the setting."], 500);
        }
    }

    public function deleteTermSetting($id)
    {
        try {
            $termSetting = TermSetting::find($id);
            if (!$termSetting) {
                return response()->json(['status' => false, 'message' => 'Term setting not found.'], 404);
            }
            $termSetting->delete();
            return response()->json(['status' => true, 'message' => 'Term setting deleted successfully.'], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting the term setting.'
            ], 500);
        }
    }

    public function updateTermSetting(Request $request, $id)
    {
        try {
            $termSetting = TermSetting::find($id);
            if (!$termSetting) {
                return response()->json(['status' => false, 'message' => 'Term setting not found.'], 404);
            }

            $data = [];

            if (isset($request->resumption_date)) {
                $data['resumption_date'] = $request->resumption_date;
            }

            if (isset($request->vacation_date)) {
                $data['vacation_date'] = $request->vacation_date;
            }

            if (isset($request->no_school_opened)) {
                $data['no_school_opened'] = $request->no_school_opened;
            }

            if (isset($request->next_term_resumption)) {
                $data['next_term_resumption'] = $request->next_term_resumption;
            }

            if (isset($request->class_count)) {
                $data['class_count'] = $request->class_count;
            }

            $termSetting->update($data);

            return response()->json(['status' => true, 'message' => 'Term setting updated successfully.'], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the term setting.'
            ], 500);
        }
    }

    public function setting()
    {
        $sessions = Period::all();
        $terms = Term::all();
        $grades = Grade::all();
        $settings = TermSetting::paginate(10);

        return view('admin.setting.index',[
            'settings' =>  $settings,
            'sessions' => $sessions,
            'terms' => $terms,
            'grades' => $grades
        ]);
    }

    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->input('ids');
            $settings = TermSetting::whereIn('id', $ids)->get();

            foreach ($settings as $setting) {
                $setting->delete();
            }

            return response()->json(['status' => true, 'message' => "Setting Deleted successfully!"], 200);

        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'message' => "There was an error deleting the settings"], 400);
        }
    }
}
