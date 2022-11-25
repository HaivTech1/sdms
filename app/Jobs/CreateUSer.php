<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\SaveCode;
use Illuminate\Bus\Queueable;
use App\Http\Requests\UserRequest;
use App\Services\SaveImageService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
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

        
        $code = SaveCode::Generator('TCH/', 5, 'reg_no', $user);
        $user->reg_no = $code;

        SaveImageService::UploadImage($this->image, $user, User::TABLE, 'profile_photo_path');
        return $user;
    }
}