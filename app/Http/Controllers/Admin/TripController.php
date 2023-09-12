<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Term;
use App\Models\Trip;
use App\Models\Grade;
use App\Models\Period;
use App\Models\StudentTrip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TripController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        return view('admin.trips.index');
    }

    public function store(Request $request)
    {
        try {
            $trip = new Trip([
                'address' => $request->get('address'),
                'price' => $request->get('price'),    
                'no_of_students' => $request->get('no_of_students'),
                'split' => $request->get('split') ? 1 : 0,
                'split_type' => $request->get('split_type') ? $request->get('split_type') : 'termly',
            ]);
            $trip->save();

            return response()->json([
                'status' => true,
                'message' => "Trip added successfully",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function downloadPdf(Request $request)
    {
        $trips = Trip::get();

        $pdf = PDF::loadHTML('generate.trip_list');
        $pdf->setOptions(['isHtml5ParserEnabled' => true]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setWarnings(false);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        );
        $pdf->loadView('generate.trip_list', ['trips' => $trips]);

        return $pdf->download('trip_list.pdf');
    }

    public function generatePaid(Request $request)
    {
        $grade = Grade::findOrFail($request->grade_id);
        $period = Period::findOrFail($request->period_id);
        $term = Term::findOrFail($request->term_id);
        $trips = StudentTrip::whereHas('student', function ($studentQuery) use ($grade) {
        $studentQuery->whereHas('grade', function ($classQuery) use ($grade) {
                $classQuery->where('id', $grade->id());
            });
        })->whereHas('payment', function ($paymentQuery) use ($grade) {
                $paymentQuery->where('payment_type', 'full');
        })->whereTrip_id($request->trip_id)->where('term_id', $term->id())->where('period_id', $period->id())->get();

        $pdf = PDF::loadHTML('generate.trip_paid_list');
        $pdf->setOptions(['isHtml5ParserEnabled' => true]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setWarnings(false);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        );
        $pdf->loadView('generate.trip_paid_list', ['trips' => $trips, 'grade' => $grade, 'period' => $period, 'term' => $term, 'type'=> 'Paid']);

        return $pdf->download('trip_paid_list.pdf');
    }

    public function generateUnPaid(Request $request)
    {
        $grade = Grade::findOrFail($request->grade_id);
        $period = Period::findOrFail($request->period_id);
        $term = Term::findOrFail($request->term_id);

        $trips = StudentTrip::whereHas('student', function ($studentQuery) use ($grade) {
            $studentQuery->whereHas('grade', function ($classQuery) use ($grade) {
                $classQuery->where('id', $grade->id());
            });
        })
        ->whereHas('payment', function ($paymentQuery) use ($grade) {
                $paymentQuery->where('payment_type', 'partial');
        })
        ->whereTrip_id($request->trip_id)->where('term_id', $term->id())->where('period_id', $period->id())
        ->get();

        $pdf = PDF::loadHTML('generate.trip_paid_list');
        $pdf->setOptions(['isHtml5ParserEnabled' => true]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setWarnings(false);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        );
        $pdf->loadView('generate.trip_paid_list', ['trips' => $trips, 'grade' => $grade, 'period' => $period, 'term' => $term, 'type'=> 'Unpaid']);

        return $pdf->download('trip_paid_list.pdf');
    }
}