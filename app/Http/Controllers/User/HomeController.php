<?php

namespace App\Http\Controllers\User;

use App\Models\Gallery;
use App\Models\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

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
                $table->enum('type', ['student', 'staff'])->default('student');

                // 🔹 Relationships
                $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
                $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
                $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

                $table->timestamps();

                // 🔹 Ensure one record per student per day
                $table->unique(['user_id', 'date']);
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

        if (!Schema::hasColumn('students', 'category')) {
            Schema::table('students', function (Blueprint $table) {
                $table->enum('category', ['primary', 'junior', 'secondary'])->default('primary')->after('gender');
            });
        }

        if (!Schema::hasColumn('registrations', 'category')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->enum('category', ['primary', 'junior', 'secondary'])->default('primary')->after('gender');
            });
        }

        if (!Schema::hasColumn('news', 'category')) {
            Schema::table('news', function (Blueprint $table) {
                $table->enum('category', ['parent', 'teacher', 'admin'])->default('parent')->after('status');
            });
        }

        if (Schema::hasTable('events')) {
            // description
            if (!Schema::hasColumn('events', 'description')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->text('description')->nullable()->after('title');
                });
            }

            // start_date
            if (!Schema::hasColumn('events', 'start_date')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dateTime('start_date')->nullable()->after('description');
                });

                if (Schema::hasColumn('events', 'start')) {
                    DB::statement("UPDATE events SET start_date = `start` WHERE `start` IS NOT NULL");
                }
            }

            // end_date
            if (!Schema::hasColumn('events', 'end_date')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->dateTime('end_date')->nullable()->after('start_date');
                });

                if (Schema::hasColumn('events', 'end')) {
                    DB::statement("UPDATE events SET end_date = `end` WHERE `end` IS NOT NULL");
                }
            }

            // time
            if (!Schema::hasColumn('events', 'time')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->time('time')->nullable()->after('end_date');
                });

                if (Schema::hasColumn('events', 'start')) {
                    DB::statement("UPDATE events SET `time` = TIME(`start`) WHERE `start` IS NOT NULL");
                } elseif (Schema::hasColumn('events', 'start_date')) {
                    DB::statement("UPDATE events SET `time` = TIME(`start_date`) WHERE `start_date` IS NOT NULL");
                }
            }

            // category (ensure it's there and string-based)
            if (!Schema::hasColumn('events', 'category')) {
                Schema::table('events', function (Blueprint $table) {
                    $table->string('category')->nullable()->after('time');
                });
            }

            // Drop week_id if still exists
            if (Schema::hasColumn('events', 'week_id')) {
                try {
                    Schema::table('events', function (Blueprint $table) {
                        $table->dropConstrainedForeignId('week_id');
                    });
                } catch (\Throwable $e) {
                    try {
                        Schema::table('events', function (Blueprint $table) {
                            $table->dropForeign(['week_id']);
                        });
                    } catch (\Throwable $ignored) {}
                    Schema::table('events', function (Blueprint $table) {
                        $table->dropColumn('week_id');
                    });
                }
            }

            // Drop old start/end if they still exist
            foreach (['start', 'end'] as $col) {
                if (Schema::hasColumn('events', $col)) {
                    Schema::table('events', function (Blueprint $table) use ($col) {
                        $table->dropColumn($col);
                    });
                }
            }
        }

        if (!Schema::hasColumn('users', 'device_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('device_token')->nullable()->after('api_token');
            });
        }

        if (!Schema::hasColumn('users', 'qrcode')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('qrcode')->nullable()->after('device_token');
            });
        }

        if (!Schema::hasColumn('payments', 'category')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('category')->nullable()->after('type');
            });
        }

        if (!Schema::hasColumn('payments', 'receipt')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('receipt')->nullable()->after('method');
            });
        }

    }
}
