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
                1
            ),
            $this->createSubject(
                'English Language',
                1
            ),
            $this->createSubject(
                'Civic Education',
                1
            ),
            $this->createSubject(
                'Economics',
                1
            ),
            $this->createSubject(
                'History',
                1
            ),
            $this->createSubject(
                'Literature-in-English',
                1
            ),
            $this->createSubject(
                'Government',
                1
            ),
            $this->createSubject(
                'Christian Religious Studies',
                1
            ),
            $this->createSubject(
                'Fine Arts/Creative Art',
                1
            ),
            $this->createSubject(
                'A Nigerian Language',
                1
            ),
            $this->createSubject(
                'Biology',
                1
            ),
            $this->createSubject(
                'Chemistry',
                1
            ),
            $this->createSubject(
                'Physics',
                1
            ),
            $this->createSubject(
                'Further Mathematics',
                1
            ),
            $this->createSubject(
                'Commerce',
                1
            ),
            $this->createSubject(
                'Accounting',
                1
            ),
            $this->createSubject(
                'Book Keeping',
                1
            ),
            $this->createSubject(
                'Animal Husbandary',
                1
            ),
            $this->createSubject(
                'Basic Science and Technology',
                1
            ),
            $this->createSubject(
                'Social Studies',
                1
            ),
            $this->createSubject(
                'Agricultural Science',
                1
            ),
            $this->createSubject(
                'Physical and Health Education',
                1
            ),
            $this->createSubject(
                'Business Studies',
                1
            ),
            $this->createSubject(
                'French',
                1
            ),
            $this->createSubject(
                'Computer Studies',
                1
            ),
            $this->createSubject(
                'Home Economics',
                1
            ),
            $this->createSubject(
                'Music',
                1
            ),
            $this->createSubject(
                'Creative and Cultural Art',
                1
            ),
            $this->createSubject(
                'Health and Physical Education',
                1
            ),
            $this->createSubject(
                'Technical Drawing (Applied Science)',
                1
            ),
            $this->createSubject(
                'Food and Nutrition',
                1
            ),
            $this->createSubject(
                'Typewriting ',
                1
            ),
            $this->createSubject(
                'Office Practice',
                1
            ),
            $this->createSubject(
                'Data Processing',
                1
            ),
            $this->createSubject(
                'Number work',
                1
            ),
            $this->createSubject(
                'Letter Work(Phonic method)',
                1
            ),
            $this->createSubject(
                'Social habit',
                1
            ),
            $this->createSubject(
                'Scientific and Reflective thinking',
                1
            ),
            $this->createSubject(
                'Writing/Patterns',
                1
            ),
            $this->createSubject(
                'Bible knowledge',
                1
            ),
            $this->createSubject(
                'Creative Arts',
                1
            ),
            $this->createSubject(
                'Rhymes/Songs',
                1
            ),
             $this->createSubject(
                'Physical excercise',
                1
            ),
            $this->createSubject(
                'Story telling',
                1
            ),
            $this->createSubject(
                'Prevocational Studies',
                1
            ),
            $this->createSubject(
                'National Value',
                1
            ),
            $this->createSubject(
                'Reading and Dictaion',
                1
            ),
            $this->createSubject(
                'Hand Writing',
                1
            ),
        ]);
    }

    private function createSubject(string $title, bool $status)
    {
        return Subject::factory()->create(compact('title', 'status'));
    }
}