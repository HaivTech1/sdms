<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $mode = env('APP_MODE');

        try {

            $appEnv = Setting::where(['key' => 'app_env'])->first();
            $result = json_decode($appEnv['value'], true);
            if ($result) {
                $data = $result == 1 ? 'production' : 'local';
                Config::set('APP_ENV', $data);
            }

            $appDebug = Setting::where('key', 'app_debug')->first();
            $value = $appDebug['value'];
            if ($value) {
                $data = $result == 1 ? true : false;
                Config::set('APP_DEBUG', $data);
            }

            $data = Setting::where(['key' => 'mail_config'])->first();
            $emailServices = json_decode($data['value'], true);
            if ($emailServices) {
                $config = array(
                    'status' => (Boolean)(isset($emailServices['status'])?$emailServices['status']:1),
                    'driver' => $emailServices['driver'],
                    'host' => $emailServices['host'],
                    'port' => $emailServices['port'],
                    'username' => $emailServices['username'],
                    'password' => $emailServices['password'],
                    'encryption' => $emailServices['encryption'],
                    'from' => array('address' => $emailServices['email_id'], 'name' => $emailServices['name']),
                    'sendmail' => '/usr/sbin/sendmail -bs',
                    'pretend' => false,
                );
                Config::set('mail', $config);
            }

            $data = Setting::where(['key' => 'paystack'])->first();
            $paystack = json_decode($data['value'], true);
            if ($paystack) {
                $config = array(
                    'publicKey' => env('PAYSTACK_PUBLIC_KEY', $paystack['publicKey']),
                    'secretKey' => env('PAYSTACK_SECRET_KEY', $paystack['secretKey']),
                    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', $paystack['paymentUrl']),
                    'merchantEmail' => env('MERCHANT_EMAIL', $paystack['merchantEmail']),
                );
                Config::set('paystack', $config);
            }

            $data = Setting::where(['key' => 'paypal'])->first();
            $paypal = json_decode($data['value'], true);
            if ($paypal) {

                if ($mode == 'live') {
                    $paypal_mode = "live";
                } else {
                    $paypal_mode = "sandbox";
                }

                $config = array(
                    'client_id' => $paypal['paypal_client_id'], // values : (local | production)
                    'secret' => $paypal['paypal_secret'],
                    'settings' => array(
                        'mode' => env('PAYPAL_MODE', $paypal_mode), //live||sandbox
                        'http.ConnectionTimeOut' => 30,
                        'log.LogEnabled' => true,
                        'log.FileName' => storage_path() . '/logs/paypal.log',
                        'log.LogLevel' => 'ERROR'
                    ),
                );
                Config::set('paypal', $config);
            }

            $data = Setting::where(['key' => 'flutterwave'])->first();
            $flutterwave = json_decode($data['value'], true);
            if ($flutterwave) {
                $config = array(
                    'publicKey' => env('FLW_PUBLIC_KEY', $flutterwave['public_key']), // values : (local | production)
                    'secretKey' => env('FLW_SECRET_KEY', $flutterwave['secret_key']),
                    'secretHash' => env('FLW_SECRET_HASH', $flutterwave['hash']),
                );
                Config::set('flutterwave', $config);
            }

            $timezone = Setting::where(['key' => 'timezone'])->first();
            if ($timezone) {
                Config::set('timezone', $timezone->value);
                date_default_timezone_set($timezone->value);
            }

            $timeformat = Setting::where(['key' => 'timeformat'])->first();
            if ($timeformat && $timeformat->value == '12') {
                Config::set('timeformat', 'h:i:a');
            }
            else{
                Config::set('timeformat', 'H:i');
            }
        } catch (\Exception $ex) {

        }
    }
}
