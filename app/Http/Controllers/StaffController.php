<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Week;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class StaffController extends Controller
{

    public function __construct()
    {
       $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin.staff.index');
    }

    public function bankList()
    {
        $apiUrl = "https://api.paystack.co/bank";
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secretKey",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return response()->json(json_decode($response));
        }
    }

    public function bankSingle($code)
    {
        $apiUrl = "https://api.paystack.co/bank";
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secretKey",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $data = json_decode($response, true);
        $results = $data['data'];

        $filterData = array_filter($results, function ($result) use ($code) {
            return $result['code'] === $code;
        });

        $newArray = array_values($filterData);

        return response()->json($newArray);
    }

    public function store(Request $request)
    {

        $user = User::findOrFail($request->employee_id);

        $url = "https://api.paystack.co/transferrecipient";
        $fields = [
            "type" => "nuban",
            "name" => $user->name,
            "account_number" => $request->account_number,
            "bank_code" => $request->bank_code,
            "currency" => "NGN"
        ];

        $result = Profile::createPaystackTransferAccount($url, $fields);

        if($result['status'] === true){
            $profile = Profile::create([
                'author_id' => $request->employee_id,
                'bank_code' => $request->bank_code,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'salary' => $request->salary,
                'paystack_id' => $result['data']['id'],
                'paystack_code' => $result['data']['recipient_code'],
            ]);
            return response()->json(['status' => true, 'message' => 'Profile created successfully!'], 200);
        }else{
            return response()->json(['status' => false, 'message' => 'There was a problem creating the profile, please try again!'], 500);
        }
    }

    public function editProfile($id)
    {

        $apiUrl = "https://api.paystack.co/bank";
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secretKey",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $profile = Profile::findOrFail($id);
        return response()->json(['data' => $profile, 'banks' => json_decode($response, true)], 200);
    }

    public function updateProfile(Request $request)
    {
        $profile = Profile::findOrFail($request->profile_id);
        $profile->update([
            'bank_code' => $request->edit_bank_code,
            'bank_name' => $request->edit_bank_name,
            'account_number' => $request->edit_account_number,
            'salary' => $request->edit_salary
        ]);

        if ($profile) {
            $result = Profile::updatePaystackRecipient($profile->pCode(), $profile->ACCTNO(), $profile->BCODE(), $profile->author()->email());

            if($result['status'] === true){
                return response()->json(['status' => true, 'message' => 'Profile updated successfully!'], 200);
            }else{
                return response()->json(['status' => false, 'message' => 'There was a problem updating the profile!'], 500);
            }
        }
    }

    public function calender()
    {
        return view('admin.staff.calendar');
    }

    public function generatePDF()
    {
        $weeks = Week::where([
            'term_id' => term('id'),
            'period_id' => period('id'),
        ])->get();
        $html = view('pdf')->with(compact('weeks'))->render();

        // Return the generated HTML to the client
        return response()->json(['html' => $html]);
    }
    
    public function duty(Request $request)
    {
        $oldTeacher = User::findOrFail($request->old_teacher_id);
        $teacher = User::findOrFail($request->teacher_id);
        $week = Week::findOrFail($request->week_id);

        $week->teachers()->detach($oldTeacher);
        $week->teachers()->attach($teacher);

        return response()->json(['status' => true, 'message' => 'Teacher has been re-assigned']);
    }

    public function assign(Request $request)
    {
        $teacher = User::findOrFail($request->teacher_id);
        $week = Week::findOrFail($request->week_id);

        if ($week->teachers()->where('user_id', $teacher->id())->exists()) {
            return response()->json(['status' => false, 'message' => 'Teacher is currently assigned to this week!'], 500);
        }else{
            $week->teachers()->attach($teacher);
            return response()->json(['status' => true, 'message' => 'Teacher has assigned successfully!'], 200);
        }

    }
}
