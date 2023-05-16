<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    use HasAuthor;

    const TABLE = 'profiles';

    protected $table = self::TABLE;

    protected $fillable = [
        'salary',
        'account_number',
        'bank_name',
        'bank_code',
        'type',
        'paystack_id',
        'paystack_code',
        'author_id',
    ];

    public static function createPaystackTransferAccount($url, $fields)
    {
        $fields_string = http_build_query($fields);

        $secretKey = env('PAYSTACK_SECRET_KEY');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $secretKey",
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);

        curl_close($ch);
        

        return json_decode($result, true);
    }

    public static function updatePaystackRecipient($recipientId, $account, $code, $email)
    {
        $url = "https://api.paystack.co/transferrecipient/" . $recipientId;

        $fields = [
            "account_number" => $account,
            "bank_code" => $code,
            'email' => $email
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . env('PAYSTACK_SECRET_KEY'),
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }


    public function id(): ?string
    {
        return (string) $this->id;
    }

    public function salary(): ?float
    {
        return (float) $this->salary;
    }

    public function ACCTNO(): ?string
    {
        return (string) $this->account_number;
    }

    public function ACCTN(): ?string
    {
        return (string) $this->bank_name;
    }

    public function BCODE(): ?string
    {
        return (string) $this->bank_code;
    }

    public function type(): ?string
    {
        return (string) $this->type;
    }

    public function pID(): string
    {
        return (string) $this->paystack_id;
    }

    public function pCode(): string
    {
        return (string) $this->paystack_code;
    }

}
