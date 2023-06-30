<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use App\Mail\SendMidtermMail;
use App\Mail\Messaging\SendMail;
use Illuminate\Support\Facades\Mail;

class Teacher extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $search = '';
    public $user_id;
    public $grade_id;



    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->teachers->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function loadMore()
    {
        $this->count += 4;
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function getTeachersProperty()
    {
        return User::where('type', User::TEACHER)->search(trim($this->search))
        ->load($this->per_page);
    }

    public function deleteAll()
    {
        User::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('success', ['message' => 'All selected teachers have been deleted!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function disableAll()
    {
        User::whereIn('id', $this->selectedRows)->update([
            'isAvailable' => false,
        ]);
        $this->dispatchBrowserEvent('success', ['message' => 'All selected teachers have been disabled!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function undisableAll()
    {
        User::whereIn('id', $this->selectedRows)->update([
            'isAvailable' => true,
        ]);
        $this->dispatchBrowserEvent('success', ['message' => 'All selected teachers have been activated!']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function sendDetails()
    {
        try {
           $teachers = User::whereIn('id', $this->selectedRows)->get();

            foreach ($teachers as $teacher) {
                $idNumber = $teacher->code();
                $name = $teacher->name;
                $message = "
                    <p>$name, use the following credentials to login into your teacher's dashbord.</p>
                    <p><b>Id Number</b>: $idNumber</p>
                    <p><b>Password</b>: password or password123 or password1234</p>
                    <p><em>Note: If you are logged in on your dashboard, please ignore this email; else, you can use either of the three passwords, one will work for you.</em></p>
                ";
                $subject = 'Portal Login Credentials';
            
                Mail::to($teacher->email())->send(new SendMidtermMail($message, $subject));
            }

            $this->dispatchBrowserEvent('success', ['message' => 'Credentials sent successfully!']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('error', ['message' => $th->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.components.admin.teacher',[
            'teachers' => $this->teachers,
            'grades' => Grade::orderBy('title')->pluck('title', 'id'),
            'allTeachers' => User::where('type', User::TEACHER)->get(),
            'activeTeachers' => User::where('type', User::TEACHER)->where('isAvailable', true)->get(),
            'unactiveTeachers' => User::where('type', User::TEACHER)->where('isAvailable', false)->get(),
            'subjects' => Subject::all()
        ]);
    }
}
