<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Term;
use App\Models\Event;
use App\Models\Grade;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $session = Period::whereStatus(1)->first();
        $term = Term::whereStatus(1)->first();

        $ids = Grade::getAllIdsExceptLast();
        $grades = Grade::gradeIds($ids)->get();

        $theterms = Term::all();
        $thesessions = Period::all();

        $news = News::get();
        $studentsData = DB::table('students')
            ->select(DB::raw('year(created_at) as year'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('year(created_at)'))
            ->get();

        // $balance_amount = $this->getPaystackBalance();

        if ($user->isSuperAdmin() || $user->isAdmin() || $user->isBursal()) {
            return view('dashboard', [
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $news,
                'studentsData' => $studentsData,
                'grades' => $grades,
                'terms' => $theterms,
                'sessions' => $thesessions,
                // 'balance' => $balance_amount,
            ]);
        } elseif ($user->isTeacher()) {
            return view('dashboard/teacher', [
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $news
            ]);
        } elseif ($user->isStudent()) {
            return view('dashboard/student', [
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $news,
                'session' => $session,
                'term' => $term,
            ]);
        }
    }

    private function getPaystackBalance()
    {
        $url = 'https://api.paystack.co/balance';
        $secret_key = env('PAYSTACK_SECRET_KEY');

        $ch = curl_init($url);

        $headers = [
            'Authorization: Bearer ' . $secret_key
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);
        $balance_amount = $data['data'][0]['balance'];

        return $balance_amount;
    }
}