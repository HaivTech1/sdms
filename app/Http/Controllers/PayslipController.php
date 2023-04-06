<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payslip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePayslipRequest;
use App\Http\Requests\UpdatePayslipRequest;

class PayslipController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth', 'bursal']);
    }

    public function index()
    {
        return view('admin.bursar.payslip',[
            'workers' => User::whereNotIn('type', [1, 4])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function single($user)
    {
        $worker = User::findOrFail($user);
        $payslip = Payslip::where('worker_id',$worker->id())->first();

        $data = $payslip->items;
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePayslipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_id' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all(),
            ], 500);
        }else {
            try {
                DB::transaction(function () use ($request) {
                    $data = [];
                    foreach (payslipList() as $key => $item) {
                        $value = $request->input($item['key']);
                        $data[$item['key']] = $value ? $value : 0;
                    }

                    $data['total'] = $request->input('total');
                    $data['pension'] = $request->input('pension');
                    $data['grossPension'] = $request->input('grossPension');
                    $data['pension10'] = $request->input('pension10');
                    $data['pension8'] = $request->input('pension8');
                    $data['paye'] = $request->input('paye');
                    $data['welfare'] = $request->input('welfare');
                    $data['others'] = $request->input('others');
                    $data['refund'] = $request->input('refund');
                    $data['contribution'] = $request->input('contribution');
                    $data['loan'] = $request->input('loan');
                    $data['net'] = $request->input('net');

                    $date = Carbon::createFromFormat('Y-m-d', $request->input('date'));
                    $month = $date->format('m');
                    $year = $date->format('Y');
    
                    $payslip = new Payslip([
                        'worker_id' => $request->input('worker_id'),
                        'author_id' => auth()->id(),
                        'month' => $month,
                        'year' => $year,
                        'items' => $data
                    ]);

                    $payslip->save();
                });

                return response()->json([
                    'status' => true,
                    'message' => 'Payment slip generated successfully!',
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
    }

  
    public function review(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $payslips = Payslip::where([
            'month' => $month,
            'year' => $year,
        ])->get();

        $data = [];
        foreach ($payslips as $payslip) {
            $data[] = [
                'id' => $payslip->id,
                'worker' => $payslip->worker->name(),
                'account_number' => $payslip->worker->profile->account_number ?? '',
                'account_bank' => $payslip->worker->profile->bank_name ?? '',
                'items' => $payslip->items
            ];
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function edit(Payslip $payslip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePayslipRequest  $request
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePayslipRequest $request, Payslip $payslip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payslip $payslip)
    {
        //
    }
}
