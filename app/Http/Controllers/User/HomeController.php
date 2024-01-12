<?php

namespace App\Http\Controllers\User;

use App\Models\Gallery;
use App\Models\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->databaseActions();
    }

    public function index()
    {
        return view('frontend.welcome');
    }

    public function gallery()
    {
        $title = "Gallery";

        $images = Gallery::where('status', true)->inRandomOrder()->get();
        return view('frontend.gallery',[
            'title' => $title,
            'images' => $images
        ]);
    }

    public function about()
    {
        $title = "About";
        
        return view('frontend.about',[
            'title' => $title,
        ]);
    }

    public function registration()
    {
        $title = "Admission";
        return view('frontend.registration',[
            'grades' => Grade::all(),
            'title' => $title,
        ]);
    }

    public function shop()
    {
        $title = "Shop";
        return view('frontend.shop',[
            'title' => $title,
        ]);
    }

    private function databaseActions()
    {
        if (!Schema::hasTable('galleries')) {
            Schema::create('galleries', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('image')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('student_reviews')) {
            Schema::create('student_reviews', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('rating',[1, 2, 3, 4, 5])->default(5);
                $table->text('content')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('parent_reviews')) {
            Schema::create('parent_reviews', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('rating',[1, 2, 3, 4, 5])->default(5);
                $table->text('content')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('website_about')) {
            Schema::create('website_about', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->enum('input_type',['text','password','email','textarea','select','radio','checkbox','file'])->nullable();
                $table->string('column_name')->nullable();
                $table->text('value')->nullable();
                $table->string('input_option')->nullable();
                $table->string('group_type')->nullable();
                $table->boolean('required')->nullable();
                $table->string('model')->nullable();
                $table->timestamps();
            });
        }
    }
}
