<?php

namespace App\Console\Commands;

use App\Models\Grade;
use App\Models\PrimaryResult;
use App\Models\Student;
use Illuminate\Console\Command;

class ResultGradePositionCalculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:position';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will set the position in all subjects for all the students';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $state = get_application_settings('cummulate_result');

        if($state == 1){
            $grades = Grade::all();
            $period = period('id');
            $term = term('id');

            foreach ($grades as $grade) {
                $students = $grade->students;

                foreach($students as $student){
                    
                    $studentsData = Student::where('uuid', $student->id())->first();
                    $updateData = []; 
                
                    $studentsData->load([
                        'primaryResults' => function ($query) use ($period, $term) {
                            $query->where('period_id', $period)->where('term_id', $term);
                        }
                    ]);
            
                    $results = $studentsData->primaryResults;
            
                    foreach ($results as $result) {
                        $updateData[] = [
                            'student_id' => $studentsData->id(),
                            'subject_id' => $result->subject_id,
                            'position_in_grade_subject' => generateStudentGradeSubjectPosition($studentsData->id(), $period,  $term, $result->subject_id, $studentsData->grade->title()) 
                        ];
                    }

                    foreach ($updateData as $data) {
                        $student_id = $data['student_id'];
                        $subject_id = $data['subject_id'];
                        $updating = PrimaryResult::where('student_id', $student_id)
                            ->where('subject_id', $subject_id)
                            ->where('period_id', $period)
                            ->where('term_id', $term)
                            ->first();
                
                        if ($updating) {
                            $updating->update([
                                'position_in_grade_subject' => $data['position_in_grade_subject'],
                            ]);
                        }
                    }
                }
            }
        }else{
            info('cummulation of result is disabled by the admin. Status: ' . $state);
        }
    }
}
