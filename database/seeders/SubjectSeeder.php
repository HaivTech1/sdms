<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = collect([
            $this->createSubject(
                'Mathematics',
            ),
            $this->createSubject(
                'English Language',
            ),
            $this->createSubject(
                'Civic Education',
            ),
            $this->createSubject(
                'Economics',
            ),
            $this->createSubject(
                'History',
            ),
            $this->createSubject(
                'Literature-in-English'
            ),
            $this->createSubject(
                'Government'
            ),
            $this->createSubject(
                'Christian Religious Studies'
            ),
            $this->createSubject(
                'Fine Arts/Creative Art'
            ),
            $this->createSubject(
                'A Nigerian Language'
            ),
            $this->createSubject(
                'Biology',
            ),
            $this->createSubject(
                'Chemistry',
            ),
            $this->createSubject(
                'Physics',
            ),
            $this->createSubject(
                'Further Mathematics',
            ),
            $this->createSubject(
                'Commerce',
            ),
            $this->createSubject(
                'Accounting',
            ),
            $this->createSubject(
                'Book Keeping',
            ),
            $this->createSubject(
                'Animal Husbandary',
            ),
            $this->createSubject(
                'Basic Science',
            ),
            $this->createSubject(
                'Social Studies',
            ),
            $this->createSubject(
                'Agricultural Science',
            ),
            $this->createSubject(
                'Physical and Health Education',
            ),
            $this->createSubject(
                'Business Studies',
            ),
            $this->createSubject(
                'French',
            ),
            $this->createSubject(
                'Computer Studies',
            ),
            $this->createSubject(
                'Home Economics',
            ),
            $this->createSubject(
                'Music',
            ),
            $this->createSubject(
                'Basic Technology',
            ),
            $this->createSubject(
                'Computer Science',
            ),
            $this->createSubject(
                'Health and Physical Education',
            ),
            $this->createSubject(
                'Technical Drawing (Applied Science)',
            ),
            $this->createSubject(
                'Food and Nutrition',
            ),
            $this->createSubject(
                'Typewriting ',
            ),
            $this->createSubject(
                'Office Practice',
            ),
            $this->createSubject(
                'Data Processing',
            ),
            $this->createSubject(
                'Number work',
            ),
            $this->createSubject(
                'Letter Work(Phonic method)',
            ),
            $this->createSubject(
                'Social habit',
            ),
            $this->createSubject(
                'Scientific and Reflective thinking',
            ),
            $this->createSubject(
                'Writing/Patterns',
            ),
            $this->createSubject(
                'Bible knowledge',
            ),
            $this->createSubject(
                'Creative Arts',
            ),
            $this->createSubject(
                'Rhymes/Songs',
            ),
             $this->createSubject(
                'Physical excercise',
            ),
            $this->createSubject(
                'Story telling',
            ),
        ]);
    }

    private function createSubject(string $title)
    {
        return Subject::factory()->create(compact('title'));
    }
}