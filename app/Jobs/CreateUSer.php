<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\SaveCode;
use Illuminate\Bus\Queueable;
use App\Mail\SendTeacherDetails;
use App\Http\Requests\UserRequest;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $title;
    private $name;
    private $email;
    private $phone;
    private $password;
    private $type;
    private $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $title,
        string $name,
        string $email,
        string $phone,
        string $password,
        string $type,
        string $image,
    )
    {
        $this->title = $title;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->type = $type;
        $this->image = $image;
    }

    public static function fromRequest(UserRequest $request): self
    {
        return new static(
            $request->title(),
            $request->name(),
            $request->email(),
            $request->phone(),
            $request->password(),
            $request->type(),
            $request->image(),
        );
    }
    
    public function handle(): User
    {
        $user = new User([
            'title' => $this->title,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone,
            'password' => Hash::make($this->password),
            'type' => $this->type
        ]);

        if($this->type == 2){
            $initial = 'ADM/';
        }elseif($this->type == 3){
            $initial = 'TCH/';
        }elseif($this->type == 4){
            $initial = 'STD/';
        }elseif($this->type == 5){
            $initial = 'BUR/';
        }elseif($this->type == 6){
            $initial = 'WOR/';
        }

        $code = SaveCode::Generator($initial, 5, 'reg_no', $user);
        $user->reg_no = $code;

        $message = "<p>You are welcome to ".application('name')." portal. Please visit ".application('website')." to login with your credentials. Id: ".$code." and your password: password1234</p>";
        $subject = 'Welcome to '.application('name'). ' Portal';

        if($this->type === '3'){
            Mail::to($this->email)->send(new SendTeacherDetails($message, $subject));
        }

        if($this->image){
            $fileName = $this->image->getClientOriginalName();
            $filePath = 'users/' . $fileName;
            $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($this->image));
    
            if ($isFileUploaded) {
                $user->profile_photo_path = $filePath;
            }
        }


        return $user;
    }
}