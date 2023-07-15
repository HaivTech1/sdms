<?php

namespace App\Exports;

use App\Models\MidTerm;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MidtermResultDataExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $grade_id;
    private $period_id;
    private $term_id;
    private $subject_id;
    
    public function __construct(Request $request)
    {
        $this->grade_id = $request->grade_id;
        $this->period_id = $request->period_id;
        $this->term_id = $request->term_id;
        $this->subject_id = $request->subject_id;
    }

    public function view(): View
    {
        $results = MidTerm::where([
            'grade_id' => $this->grade_id,
            'period_id' => $this->period_id,
            'term_id' => $this->term_id,
            'subject_id' => $this->subject_id
        ])->get();

        return view('generate.midtermExcel', ['results' => $results]);
    }
}
