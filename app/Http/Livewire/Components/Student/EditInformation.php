<?php

namespace App\Http\Livewire\Components\Student;

use DateTime;
use App\Models\Club;
use App\Models\User;
use App\Models\House;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditInformation extends Component
{
    use WithFileUploads;

    public Student $student;
    public User $user;
    public $state = [];
    public $photo;

    public function mount()
    {
        $this->student = Student::where('user_id', auth()->id())->first();
        $this->user = User::findOrFail(auth()->id());
        $this->state = $this->student->toArray();
    }

    public function updateStudentInformation()
    {

        $this->student->update([
            'first_name' => $this->state['first_name'],
            'last_name' => $this->state['last_name'],
            'other_name' => $this->state['other_name'],
            'gender' => $this->state['gender'],
            'dob' => $this->state['dob'],
            'house_id' => $this->state['house_id'],
            'club_id' => $this->state['club_id'],
        ]);

        $this->user->update([
            'name' => $this->student->last_name . ' ' . $this->student->first_name . ' ' . $this->student->other_name
        ]);

        if (isset($this->photo)) {
            $this->user->updateProfilePhoto($this->photo);
        }

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.components.student.edit-information', [
            'houses' => House::all(),
            'clubs' => Club::all(),
        ]);
    }
}
