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
        return view('frontend.gallery', [
            'title' => $title,
            'images' => $images
        ]);
    }

    public function about()
    {
        $title = "About";

        return view('frontend.about', [
            'title' => $title,
        ]);
    }

    public function registration()
    {
        $title = "Admission";
        return view('frontend.registration', [
            'grades' => Grade::whereNotIn("id", [30, 27])->get(),
            'title' => $title,
        ]);
    }

    public function shop()
    {
        $title = "Shop";
        return view('frontend.shop', [
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

        // if (!Schema::hasTable('student_reviews')) {
        //     Schema::create('student_reviews', function (Blueprint $table) {
        //         $table->id();
        //         $table->string('name')->nullable();
        //         $table->enum('rating',[1, 2, 3, 4, 5])->default(5);
        //         $table->text('content')->nullable();
        //         $table->timestamps();
        //     });
        // }

        if (!Schema::hasTable('parent_reviews')) {
            Schema::create('parent_reviews', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('rating', [1, 2, 3, 4, 5])->default(5);
                $table->text('content')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('website_about')) {
            Schema::create('website_about', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->enum('input_type', ['text', 'password', 'email', 'textarea', 'select', 'radio', 'checkbox', 'file'])->nullable();
                $table->string('column_name')->nullable();
                $table->text('value')->nullable();
                $table->string('input_option')->nullable();
                $table->string('group_type')->nullable();
                $table->boolean('required')->nullable();
                $table->string('model')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('scheduled_birthdays')) {
            Schema::create('scheduled_birthdays', function (Blueprint $table) {
                $table->id();
                $table->foreignUuid('student_id')->references('uuid')->on('students')->onDelete('cascade');
                $table->string('date')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('scheduled_event')) {
            Schema::create('scheduled_event', function (Blueprint $table) {
                $table->id();
                $table->foreignUuid('student_id')->references('uuid')->on('students')->onDelete('cascade');
                $table->integer('event_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('mid_terms', 'deleted_at')) {
            Schema::table('mid_terms', function (Blueprint $table) {
                $table->timestamp('deleted_at')->after('updated_at')->nullable();
            });
        }

        if (!Schema::hasColumn('primary_results', 'deleted_at')) {
            Schema::table('primary_results', function (Blueprint $table) {
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if (!Schema::hasTable('term_settings')) {
            Schema::create('term_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
                $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
                $table->date('resumption_date');
                $table->date('vacation_date');
                $table->date('next_term_resumption');
                $table->integer('no_school_opened');
                $table->json('class_count')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('students', 'qrcode')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('qrcode')->nullable()->after('type');
            });
        }

        if (!Schema::hasTable('attendance_dailies')) {
            Schema::create('attendance_dailies', function (Blueprint $table) {
                $table->id();

                $table->date('date'); 

                $table->timestamp('am_check_in_at')->nullable(); 
                $table->boolean('am_status')->default(0); 

                $table->timestamp('pm_check_out_at')->nullable();
                $table->boolean('pm_status')->default(0); 

                $table->text('note')->nullable();

                // 🔹 Relationships
                $table->foreignUuid('student_id')->constrained('students')->onDelete('cascade');
                $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
                $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
                $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

                $table->timestamps();

                // 🔹 Ensure one record per student per day
                $table->unique(['student_id', 'date']);
            });
        }

        if (!Schema::hasColumn('registrations', 'state')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->enum('state', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            });
        }

        if (!Schema::hasTable('grade_subjects')) {
            Schema::create('grade_subjects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('grade_id')->constrained()->cascadeOnDelete();
                $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
                $table->unique(['grade_id', 'subject_id']);
                $table->timestamps();
            });
        }
    }
}
