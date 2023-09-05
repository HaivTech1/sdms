<?php

namespace App\Exports;

use App\Models\Subject;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubjectExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $subjects;
    
    public function __construct($subjects)
    {
        $this->subjects = $subjects;
    }

    public function view(): View
    {
        $subjects = Subject::whereIn('id', $this->subjects)->get();
        return view('generate.subjectExcel', ['subjects' => $subjects]);
    }
}